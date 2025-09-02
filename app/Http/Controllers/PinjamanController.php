<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Utils\Helper;

class PinjamanController extends Controller
{
    public function HalamanPinjaman(Request $request)
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
            $a->total_pinjaman = Helper::stringToRupiah($a->pinjaman->sum->tunggakan);
        }

        return view("pages.pinjaman", [
            'anggota' => $anggota
        ]);
    }

    public function HalamanDaftarPinjamanAnggota(string $id_anggota)
    {
        $anggota = Anggota::where('id', '=', $id_anggota)->first();

        $total_seluruh_pinjaman = $anggota->pinjaman->sum(function ($pinjaman) {
            return $pinjaman->jumlah_pinjaman - $pinjaman->angsuran->sum('jumlah_angsuran');
        });

        foreach ($anggota->pinjaman as $pinjaman) {
            $pinjaman->tgl_pinjaman = Helper::getTanggalAttribute($pinjaman->tgl_pinjaman);
            $pinjaman->jatuh_tempo = Helper::getTanggalAttribute($pinjaman->jatuh_tempo);
            $pinjaman->tunggakan_rupiah = Helper::stringToRupiah($pinjaman->tunggakan);
        }

        return view("pages.daftar-pinjaman-anggota", [
            'anggota' => $anggota,
            'total_pinjaman' => Helper::stringToRupiah($total_seluruh_pinjaman),
        ]);
    }

    public function HalamanTambahPinjaman()
    {
        $anggota = Anggota::all();

        return view('pages.tambah-pinjaman', [
            'anggota' => $anggota
        ]);
    }

    public function TambahPinjaman(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'tgl_pinjaman' => 'required|date',
            'jaminan' => 'nullable|string|max:255',
            'jumlah_pinjaman' => 'required|numeric|min:1',
            'tenor' => 'required|integer|min:1', // tenor wajib diisi minimal 1 bulan
            'jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjaman', // tanggal jatuh tempo harus >= tgl pinjaman
        ]);

        // Simpan data pinjaman
        Pinjaman::create($validated);

        return redirect()
            ->route('admin.pinjaman')
            ->with('msg_success', 'Pinjaman Berhasil Ditambahkan');
    }

    public function HalamanEditPinjaman(string $id_pinjaman)
    {
        $pinjaman = Pinjaman::where('id', '=', $id_pinjaman)->first();

        return view('pages.edit-pinjaman', [
            'pinjaman' => $pinjaman,
        ]);
    }

    public function EditPinjaman(Request $request, string $id_pinjaman)
    {
        $validated = $request->validate([
            'tgl_pinjaman' => 'required|date',
            'jaminan' => 'nullable|string|max:255',
            'jumlah_pinjaman' => 'required|numeric|min:1',
            'tenor' => 'required|integer|min:1', // tenor wajib diisi minimal 1 bulan
            'jatuh_tempo' => 'required|date|after_or_equal:tgl_pinjaman', // tanggal jatuh tempo harus >= tgl pinjaman
        ]);

        $pinjaman = Pinjaman::where("id", "=", $id_pinjaman)->first();
        if (!$pinjaman->update($validated)) {
            return redirect()
                ->route("admin.detail-pinjaman", ['id_anggota' => $pinjaman->id_anggota])
                ->with('msg_error', 'Pinjaman Gagal Diubah');
        }

        return redirect()
            ->route("admin.daftar-pinjaman-anggota", ['id_anggota' => $pinjaman->id_anggota])
            ->with('msg_success', 'Pinjaman Berhasil Diubah');
    }

    public function HapusPinjaman(string $id_pinjaman)
    {
        $pinjaman = Pinjaman::where("id", "=", $id_pinjaman)->first();
        if (!$pinjaman || !$pinjaman->delete()) {
            return redirect()
                ->route('admin.detail-pinjaman', ['id_anggota' => $pinjaman->id_anggota])
                ->with('msg_error', 'Gagal menghapus pinjaman');
        }

        return redirect()
            ->route('admin.detail-pinjaman', ['id_anggota' => $pinjaman->id_anggota])
            ->with('msg_success', 'Berhasil menghapus pinjaman');
    }
}
