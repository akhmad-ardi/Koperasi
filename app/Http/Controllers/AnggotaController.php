<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Anggota;
use App\Utils\Helper;

class AnggotaController extends Controller
{
    public function HalamanAnggota(Request $request)
    {
        $keyword = $request->input('nama');

        // query anggota
        $anggotaQuery = Anggota::query();

        if (!empty($keyword)) {
            $anggotaQuery->where('nama', 'LIKE', "%{$keyword}%");
        }

        $anggota = $anggotaQuery->get();

        foreach ($anggota as $a) {
            $a->tgl_lahir = Helper::getTanggalAttribute($a->tgl_lahir);
        }

        $anggota = $anggota->sortByDesc('tgl_gabung');

        return view('pages.anggota', [
            'anggota' => $anggota
        ]);
    }

    public function HalamanDetailAnggota(string $id_anggota)
    {
        $anggota = Anggota::where("id", "=", $id_anggota)->first();
        if (!$anggota) {
            return redirect()
                ->route('admin.anggota')
                ->with('msg_error', 'Anggota tidak ditemukan');
        }

        return view("pages.detail-anggota", [
            'anggota' => $anggota
        ]);
    }

    public function HalamanTambahAnggota()
    {
        $sekolah = Sekolah::all();

        return view("pages.tambah-anggota", [
            'sekolah' => $sekolah
        ]);
    }

    public function TambahAnggota(Request $request)
    {
        $request->validate([
            'no_anggota' => 'required|string|max:50|unique:anggota,no_anggota',
            'nama' => 'required|string|max:255',
            'id_sekolah' => 'required|exists:sekolah,id',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:anggota,nik',
            'nip' => 'required|numeric|digits_between:5,20',
            'foto_diri' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|string|in:aktif,nonaktif',
        ]);

        $anggotaAlreadyExist = Anggota::where("no_anggota", "=", $request->no_anggota)->first();
        if ($anggotaAlreadyExist) {
            return redirect()
                ->route('admin.tambah-anggota')
                ->with('msg_error', 'Nommor Anggota Sudah Ada');
        }

        $fotoPath = null;
        if ($request->hasFile('foto_diri')) {
            $fotoPath = $request->file('foto_diri')->store('foto', 'public');
        }

        // Simpan ke database
        Anggota::create([
            'no_anggota' => $request->no_anggota,
            'nama' => $request->nama,
            'id_sekolah' => $request->id_sekolah,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'pekerjaan' => $request->pekerjaan,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'foto_diri' => $fotoPath,
            'status' => $request->status,
            'tgl_gabung' => now()
        ]);

        return redirect()
            ->route('admin.anggota')
            ->with('msg_success', 'Anggota Berhasil Ditambahkan');
    }

    public function HalamanEditAnggota(string $id_anggota)
    {
        $sekolah = Sekolah::all();

        $anggota = Anggota::where("id", "=", $id_anggota)->first();
        if (!$anggota) {
            return redirect()
                ->route('admin.anggota')
                ->with('msg_error', 'Anggota tidak ditemukan');
        }

        return view("pages.edit-anggota", [
            'anggota' => $anggota,
            'sekolah' => $sekolah
        ]);
    }

    public function EditAnggota(Request $request, string $id_anggota)
    {
        $request->validate([
            'no_anggota' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'id_sekolah' => 'required|exists:sekolah,id',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'nip' => 'required|numeric|digits_between:5,20',
            'foto_diri' => 'image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|string|in:aktif,nonaktif',
        ]);

        $anggota = Anggota::findOrFail($id_anggota);

        $anggotaAlreadyExist = Anggota::where('no_anggota', $request->no_anggota)
            ->where('id', '!=', $id_anggota) // <- ini penting, agar tidak bentrok dengan dirinya sendiri
            ->first();

        if ($anggotaAlreadyExist) {
            return redirect()
                ->route('admin.edit-anggota', $id_anggota) // redirect balik ke form edit
                ->with('msg_error', 'Nomor Anggota sudah digunakan anggota lain');
        }

        if ($request->hasFile('foto_diri')) {
            $fotoPath = $request->file('foto_diri')->store('foto', 'public');

            $anggota->foto_diri = $fotoPath;
        }

        $anggota->no_anggota = $request->no_anggota;
        $anggota->nama = $request->nama;
        $anggota->id_sekolah = $request->id_sekolah;
        $anggota->jenis_kelamin = $request->jenis_kelamin;
        $anggota->tempat_lahir = $request->tempat_lahir;
        $anggota->tgl_lahir = $request->tgl_lahir;
        $anggota->pekerjaan = $request->pekerjaan;
        $anggota->no_telepon = $request->no_telepon;
        $anggota->alamat = $request->alamat;
        $anggota->nik = $request->nik;
        $anggota->nip = $request->nip;
        $anggota->status = $request->status;

        $anggota->save();

        return redirect()
            ->route('admin.anggota')
            ->with("msg_success", "Anggota Berhasil Diubah");
    }

    public function HapusAnggota(string $id_anggota)
    {
        $delete_anggota = Anggota::where('id', '=', $id_anggota)->delete();
        if (!$delete_anggota) {
            return redirect()
                ->route('admin.anggota')
                ->with('msg_error', "Anggota Gagal Dihapus");
        }

        return redirect()
            ->route('admin.anggota')
            ->with('msg_success', "Anggota Berhasil Dihapus");
    }
}
