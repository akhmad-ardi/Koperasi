<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Utils\Helper;

class SimpananController extends Controller
{
    public function HalamanSimpanan(Request $request)
    {
        // ambil keyword dari input form pencarian
        $keyword = $request->input('nama');

        // query anggota (jika ada pencarian nama)
        $anggotaQuery = Anggota::query();

        if (!empty($keyword)) {
            $anggotaQuery->where('nama', 'LIKE', "%{$keyword}%");
        }

        $anggota = $anggotaQuery->get();


        foreach ($anggota as $a) {
            // hitung simpanan per jenis
            $simpanan_pokok = $a->simpanan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_simpanan');
            $simpanan_wajib = $a->simpanan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_simpanan');
            $simpanan_sukarela = $a->simpanan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_simpanan');

            // hitung penarikan per jenis
            $penarikan_pokok = $a->penarikan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_penarikan');
            $penarikan_wajib = $a->penarikan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_penarikan');
            $penarikan_sukarela = $a->penarikan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_penarikan');

            // saldo per jenis untuk anggota ini
            $saldo_pokok = max(0, $simpanan_pokok - $penarikan_pokok);
            $saldo_wajib = max(0, $simpanan_wajib - $penarikan_wajib);
            $saldo_sukarela = max(0, $simpanan_sukarela - $penarikan_sukarela);

            // simpan ke object anggota (biar bisa dipakai di view)
            $a->saldo_pokok = Helper::stringToRupiah($saldo_pokok);
            $a->saldo_wajib = Helper::stringToRupiah($saldo_wajib);
            $a->saldo_sukarela = Helper::stringToRupiah($saldo_sukarela);
        }

        return view('pages.simpanan', [
            'anggota' => $anggota,
        ]);
    }

    public function HalamanDetailSimpanan(string $id_anggota)
    {
        $anggota = Anggota::with('sekolah')
            ->where('id', $id_anggota)
            ->first();

        $total_simpanan_pokok = $anggota->simpanan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_simpanan');
        $total_simpanan_wajib = $anggota->simpanan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_simpanan');
        $total_simpanan_sukarela = $anggota->simpanan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_simpanan');

        $total_penarikan_pokok = $anggota->penarikan->where('jenis_simpanan', '=', 'pokok')->sum('jumlah_penarikan');
        $total_penarikan_wajib = $anggota->penarikan->where('jenis_simpanan', '=', 'wajib')->sum('jumlah_penarikan');
        $total_penarikan_sukarela = $anggota->penarikan->where('jenis_simpanan', '=', 'sukarela')->sum('jumlah_penarikan');

        // total per jenis
        $saldo_pokok = max(0, $total_simpanan_pokok - $total_penarikan_pokok);
        $saldo_wajib = max(0, $total_simpanan_wajib - $total_penarikan_wajib);
        $saldo_sukarela = max(0, $total_simpanan_sukarela - $total_penarikan_sukarela);

        foreach ($anggota->simpanan as $s) {
            $s->tgl_simpanan_dmy = Helper::getTanggalAttribute($s->tgl_simpanan);
            $s->jumlah_simpanan = Helper::stringToRupiah($s->jumlah_simpanan);
        }

        return view("pages.detail-simpanan", [
            "anggota" => $anggota,
            'simpanan_pokok' => Helper::stringToRupiah($saldo_pokok),
            'simpanan_wajib' => Helper::stringToRupiah($saldo_wajib),
            'simpanan_sukarela' => Helper::stringToRupiah($saldo_sukarela),
        ]);
    }

    public function HalamanTambahSimpanan()
    {
        $anggota = Anggota::all();

        return view('pages.tambah-simpanan', [
            'anggota' => $anggota
        ]);
    }

    public function TambahSimpanan(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => ['required', 'exists:anggota,id'],
            'tgl_simpanan' => ['required', 'date'],
            "jenis_simpanan" => ['required'],
            'jumlah_simpanan' => ['required', 'numeric', 'min:1'],
        ]);

        Simpanan::create($validated);

        return redirect()
            ->route('admin.simpanan')
            ->with('msg_success', 'Simpanan Berhasil Ditambahkan');
    }

    public function EditSimpanan(Request $request, string $id_simpanan)
    {
        $validated = $request->validate([
            'tgl_simpanan' => ['required', 'date'],
            "jenis_simpanan" => ['required'],
            'jumlah_simpanan' => ['required', 'numeric', 'min:1'],
        ]);

        $simpanan = Simpanan::where("id", "=", $id_simpanan)->first();
        if (!$simpanan->update($validated)) {
            return redirect()
                ->route('admin.detail-simpanan', ['id_anggota' => $simpanan->id_anggota])
                ->with('msg_error', 'Simpanan Gagal Diubah');
        }

        return redirect()
            ->route('admin.detail-simpanan', ['id_anggota' => $simpanan->id_anggota])
            ->with('msg_success', 'Simpanan Berhasil Diubah');
    }

    public function HapusSimpanan(string $id_simpanan)
    {
        $simpanan = Simpanan::where("id", "=", $id_simpanan)->first();
        if (!$simpanan || $simpanan->delete()) {
            return redirect()
                ->route('admin.detail-simpanan', ['id_anggota' => $simpanan->id_anggota])
                ->with('msg_error', 'Gagal menghapus data');
        }

        return redirect()
            ->route('admin.detail-simpanan', ['id_anggota' => $simpanan->id_anggota])
            ->with('msg_success', 'Berhasil menghapus data');
    }

}
