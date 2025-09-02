<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Penarikan;
use App\Utils\Helper;

class PenarikanController extends Controller
{
    public function HalamanPenarikan(Request $request)
    {
        $anggota = Anggota::all();

        $keyword = $request->input('nama');

        // query anggota
        $anggotaQuery = Anggota::query();

        if (!empty($keyword)) {
            $anggotaQuery->where('nama', 'LIKE', "%{$keyword}%");
        }

        $anggota = $anggotaQuery->get();

        foreach ($anggota as $a) {
            // hitung simpanan per jenis
            $penarikan_pokok = $a->penarikan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_penarikan');
            $penarikan_wajib = $a->penarikan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_penarikan');
            $penarikan_sukarela = $a->penarikan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_penarikan');

            // simpan ke object anggota (biar bisa dipakai di view)
            $a->total_penarikan_pokok = Helper::stringToRupiah($penarikan_pokok);
            $a->total_penarikan_wajib = Helper::stringToRupiah($penarikan_wajib);
            $a->total_penarikan_sukarela = Helper::stringToRupiah($penarikan_sukarela);
        }

        return view('pages.penarikan', [
            'anggota' => $anggota
        ]);
    }

    public function HalamanDetailPenarikan(string $id_anggota)
    {
        $anggota = Anggota::with('sekolah')
            ->where('id', $id_anggota)
            ->first();

        // total per jenis
        $penarikan_pokok = $anggota->penarikan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_penarikan');
        $penarikan_wajib = $anggota->penarikan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_penarikan');
        $penarikan_sukarela = $anggota->penarikan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_penarikan');

        $jumlah_simpanan_pokok = $anggota->simpanan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_simpanan');
        $jumlah_simpanan_wajib = $anggota->simpanan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_simpanan');
        $jumlah_simpanan_sukarela = $anggota->simpanan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_simpanan');

        $total_simpanan_pokok = $jumlah_simpanan_pokok - $penarikan_pokok;
        $total_simpanan_wajib = $jumlah_simpanan_wajib - $penarikan_wajib;
        $total_simpanan_sukarela = $jumlah_simpanan_sukarela - $penarikan_sukarela;

        foreach ($anggota->penarikan as $s) {
            $s->tgl_penarikan_dmy = Helper::getTanggalAttribute($s->tgl_penarikan);
            $s->jumlah_penarikan_rupiah = Helper::stringToRupiah($s->jumlah_penarikan);
        }

        return view("pages.detail-penarikan", [
            "anggota" => $anggota,
            'penarikan_pokok' => Helper::stringToRupiah($penarikan_pokok),
            'penarikan_wajib' => Helper::stringToRupiah($penarikan_wajib),
            'penarikan_sukarela' => Helper::stringToRupiah($penarikan_sukarela),
            'total_simpanan_pokok' => $total_simpanan_pokok,
            'total_simpanan_wajib' => $total_simpanan_wajib,
            'total_simpanan_sukarela' => $total_simpanan_sukarela,
        ]);
    }

    public function HalamanTambahPenarikan()
    {
        $anggota = Anggota::with(['simpanan', 'penarikan'])->get();

        $anggota->map(function ($a) {
            $simpananPerJenis = $a->simpanan->groupBy('jenis_simpanan')->map->sum('jumlah_simpanan');
            $penarikanPerJenis = $a->penarikan->groupBy('jenis_simpanan')->map->sum('jumlah_penarikan');

            $saldo = [];
            foreach (['pokok', 'wajib', 'sukarela'] as $jenis) {
                $totalSimpanan = $simpananPerJenis[$jenis] ?? 0;
                $totalPenarikan = $penarikanPerJenis[$jenis] ?? 0;
                $saldo[$jenis] = $totalSimpanan - $totalPenarikan; // SALDO AKHIR
            }

            $a->saldo_per_jenis = $saldo;
            return $a;
        });

        return view('pages.tambah-penarikan', [
            'anggota' => $anggota
        ]);
    }

    public function TambahPenarikan(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'tgl_penarikan' => 'required|date',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah_penarikan' => 'required|numeric|min:1000',
        ]);

        $simpanan = Simpanan::where('id_anggota', '=', $validated['id_anggota'])
            ->where('jenis_simpanan', '=', $validated['jenis_simpanan'])
            ->first();
        if (!$simpanan) {
            return redirect()
                ->route('admin.tambah-penarikan')
                ->with('msg_error', 'Simpanan Tidak Ada');
        }

        if ($simpanan->jumlah_simpanan < $validated['jumlah_penarikan']) {
            return redirect()
                ->route('admin.tambah-penarikan')
                ->with('msg_error', 'Simpanan Tidak Mencukupi');
        }

        Penarikan::create($validated);

        return redirect()
            ->route('admin.penarikan')
            ->with('msg_success', 'Berhasil Menarik Simpanan');
    }

    public function EditPenarikan(Request $request, string $id_penarikan)
    {
        $validated = $request->validate([
            'tgl_penarikan' => 'required|date',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah_penarikan' => 'required|numeric|min:1000',
        ]);

        $penarikan = Penarikan::where("id", "=", $id_penarikan)->first();
        if (!$penarikan) {
            return redirect()
                ->route('admin.penarikan')
                ->with('msg_error', 'Penarikan Tidak Ada');
        }

        $simpanan = Simpanan::where('id', '=', $penarikan->id_anggota)->first();
        if (!$simpanan) {
            return redirect()
                ->route('admin.penarikan')
                ->with('msg_error', 'Simpanan Tidak Ada');
        }

        if ($simpanan->jumlah_simpanan < $validated['jumlah_penarikan']) {
            return redirect()
                ->route('admin.detail-penarikan', ['id_anggota' => $penarikan->id_anggota])
                ->with('msg_error', 'Simpanan Tidak Mencukupi');
        }

        if (
            !$penarikan->update([
                "tgl_penarikan" => $validated['tgl_penarikan'],
                "jenis_simpanan" => $validated['jenis_simpanan'],
                "jumlah_penarikan" => $validated['jumlah_penarikan'],
            ])
        ) {
            return redirect()
                ->route('admin.detail-penarikan', ['id_anggota' => $penarikan->id_anggota])
                ->with("msg_error", "Gagal Melakukan Penarikan");
        }

        return redirect()
            ->route('admin.detail-penarikan', ['id_anggota' => $penarikan->id_anggota])
            ->with("msg_success", "Berhasil Melakukan Penarikan");
    }

    public function HapusPenarikan(string $id_penarikan)
    {
        $penarikan = Penarikan::where("id", '=', $id_penarikan)->first();
        if (!$penarikan || !$penarikan->delete()) {
            return redirect()
                ->route('admin.detail-penarikan', ['id_anggota' => $penarikan->id_anggota])
                ->with('msg_error', 'Gagal menghapus data');
        }

        return redirect()
            ->route('admin.detail-penarikan', ['id_anggota' => $penarikan->id_anggota])
            ->with('msg_success', 'Berhasil menghapus data');
    }
}
