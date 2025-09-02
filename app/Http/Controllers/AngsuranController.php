<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use App\Utils\Helper;

class AngsuranController extends Controller
{
    public function HalamanDetailPinjaman(string $id_pinjaman)
    {
        $pinjaman = Pinjaman::where('id', '=', $id_pinjaman)->first();

        $total_angsuran = $pinjaman->angsuran->sum('jumlah_angsuran');

        $pinjaman->jumlah_pinjaman = Helper::stringToRupiah($pinjaman->jumlah_pinjaman - $total_angsuran);

        foreach ($pinjaman->angsuran as $angsuran) {
            $angsuran->jumlah_angsuran_rupiah = Helper::stringToRupiah($angsuran->jumlah_angsuran);
            $angsuran->jasa_rupiah = Helper::stringToRupiah($angsuran->jasa);
            $angsuran->total_angsuran_rupiah = Helper::stringToRupiah($angsuran->total_angsuran);
        }

        return view('pages.detail-pinjaman', [
            'pinjaman' => $pinjaman,
        ]);
    }

    public function HalamanTambahAngsuran(string $id_pinjaman)
    {
        $pinjaman = Pinjaman::where('id', '=', $id_pinjaman)->first();

        $total_pinjaman = $pinjaman->sum('jumlah_pinjaman');
        $total_angsuran = $pinjaman->angsuran->sum('jumlah_angsuran');

        return view('pages.tambah-angsuran', [
            'pinjaman' => $pinjaman,
            'total_pinjaman' => Helper::stringToRupiah($total_pinjaman - $total_angsuran)
        ]);
    }

    public function TambahAngsuran(Request $request, string $id_pinjaman)
    {
        $validated = $request->validate([
            'tgl_angsuran' => ['required', 'date'],
            'jumlah_angsuran' => ['required', 'numeric', 'min:1'],
        ]);

        $pinjaman = Pinjaman::where("id", '=', $id_pinjaman)->first();

        $jumlah_pinjaman = $pinjaman->sum('jumlah_pinjaman');
        $jumlah_angsuran = $pinjaman->angsuran->sum('jumlah_angsuran');

        $sisa_pinjaman = $jumlah_pinjaman - $jumlah_angsuran;

        $jasa = $sisa_pinjaman * 0.03;
        $total_angsuran = $validated['jumlah_angsuran'] + $jasa;

        Angsuran::create([
            'id_pinjaman' => $id_pinjaman,
            'tgl_angsuran' => $validated['tgl_angsuran'],
            'jumlah_angsuran' => $validated['jumlah_angsuran'],
            'jasa' => $jasa,
            'total_angsuran' => $total_angsuran,
        ]);

        return redirect()
            ->route('admin.detail-pinjaman', ['id_pinjaman' => $id_pinjaman])
            ->with('msg_success', 'Berhasil Ditambahkan');
    }

    public function EditAngsuran(Request $request, string $id_angsuran)
    {
        $validated = $request->validate([
            'tgl_angsuran' => ['required', 'date'],
            'jumlah_angsuran' => ['required', 'numeric', 'min:1'],
        ]);

        $angsuran = Angsuran::where("id", "=", $id_angsuran)->first();
        if (!$angsuran) {
            return redirect()
                ->route("admin.pinjaman")
                ->with("msg_error", "Angsuran Tidak Dtemukan");
        }

        $jumlah_pinjaman = $angsuran->pinjaman->jumlah_pinjaman;
        $jumlah_angsuran = $angsuran->jumlah_angsuran;

        $sisa_pinjaman = $jumlah_pinjaman - $jumlah_angsuran;

        $jasa = $sisa_pinjaman * 0.03;
        $total_angsuran = $validated['jumlah_angsuran'] + $jasa;

        $angsuran->update([
            'tgl_angsuran' => $validated['tgl_angsuran'],
            'jumlah_angsuran' => $validated['jumlah_angsuran'],
            'jasa' => $jasa,
            'total_angsuran' => $total_angsuran,
        ]);

        return redirect()
            ->route("admin.detail-pinjaman", ["id_pinjaman" => $angsuran->pinjaman->id])
            ->with("msg_success", "Angsuran Berhasil Diubah");
    }

    public function HapusAngsuran(string $id_angsuran)
    {
        $angsuran = Angsuran::where("id", '=', $id_angsuran)->first();
        if (!$angsuran || !$angsuran->delete()) {
            return redirect()
                ->route('admin.detail-pinjaman', ['id_anggota' => $angsuran->id_pinjaman])
                ->with('msg_error', "Gagal menghapus angsuran");
        }

        return redirect()
            ->route('admin.detail-pinjaman', ['id_pinjaman' => $angsuran->id_pinjaman])
            ->with('msg_success', "Berhasil menghapus angsuran");
    }
}
