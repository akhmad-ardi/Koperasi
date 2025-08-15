<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Sekolah;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Penarikan;
use App\Models\Pinjaman;
use App\Models\Angsuran;
use App\Utils\Helper;

class AdminController extends Controller
{
    public function HalamanDashboard()
    {
        $total_sekolah = Sekolah::all()->count();
        $total_anggota = Anggota::all()->count();
        $total_simpanan = Helper::stringToRupiah(Simpanan::sum('jumlah_simpanan'));
        $total_pinjaman = Helper::stringToRupiah(Pinjaman::sum('jumlah_pinjaman'));
        $total_angsuran = Helper::stringToRupiah(Angsuran::sum('jumlah_angsuran'));
        $total_penarikan = Helper::stringToRupiah(Penarikan::sum('jumlah_penarikan'));

        return view('pages.dashboard', [
            "total_sekolah" => $total_sekolah,
            "total_anggota" => $total_anggota,
            "total_simpanan" => $total_simpanan,
            "total_pinjaman" => $total_pinjaman,
            "total_angsuran" => $total_angsuran,
            "total_penarikan" => $total_penarikan
        ]);
    }

    public function HalamanSekolah()
    {
        $sekolah = Sekolah::all();

        return view('pages.sekolah', [
            'sekolah' => $sekolah
        ]);
    }

    public function HalamanTambahSekolah()
    {
        return view('pages.tambah-sekolah');
    }

    public function TambahSekolah(Request $request)
    {
        $request->validate([
            'nama_sekolah' => ['required'],
            'alamat' => ['required']
        ]);

        $data = [
            'nama_sekolah' => $request->input('nama_sekolah'),
            'alamat' => $request->input('alamat'),
        ];

        Sekolah::create($data);

        return redirect()
            ->route('admin.sekolah')
            ->with('msg_success', 'Sekolah Berhasil Ditambahkan');
    }

    public function EditSekolah(Request $request, string $id)
    {
        try {
            $request->validate([
                'nama_sekolah' => ['required'],
                'alamat' => ['required']
            ]);
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('modal_id', $id)
                ->withErrors($e->validator);
        }

        $data = [
            'nama_sekolah' => $request->input('nama_sekolah'),
            'alamat' => $request->input('alamat'),
        ];

        Sekolah::where('id', '=', $id)->update($data);

        return redirect()
            ->route('admin.sekolah')
            ->with('msg_success', $data['nama_sekolah'] . ' Berhasil Diubah');
    }

    public function HapusSekolah(Request $request, string $id)
    {
        $sekolah = Sekolah::where('id', '=', $id)->first();
        if (!$sekolah) {
            return redirect()
                ->route('admin.sekolah')
                ->with('msg_success', 'Sekolah tidak ditemukan');
        }

        Sekolah::where('id', '=', $id)->delete();

        return redirect()
            ->route('admin.sekolah')
            ->with('msg_success', $sekolah['nama_sekolah'] . ' Berhasil Dihapus');
    }

    public function HalamanAnggota()
    {
        $anggota = Anggota::all();

        foreach ($anggota as $a) {
            $a->tgl_lahir = Helper::getTanggalAttribute($a->tgl_lahir);
        }

        $anggota = $anggota->sortByDesc('tgl_gabung');

        return view('pages.anggota', [
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
            'status' => 'required|string|max:50',
        ]);

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

    public function HalamanSimpanan()
    {
        return view('pages.simpanan');
    }

    public function HalamanTambahSimpanan()
    {
        return view('pages.tambah-simpanan');
    }

    public function HalamanPinjaman()
    {
        return view("pages.pinjaman");
    }

    public function HalamanTambahPinjaman()
    {
        return view('pages.tambah-pinjaman');
    }

    public function HalamanPenarikan()
    {
        return view('pages.penarikan');
    }

    public function HalamanTambahPenarikan()
    {
        return view('pages.tambah-penarikan');
    }

    public function HalamanLaporanSimpanan()
    {
        return view('pages.laporan-simpanan');
    }

    public function HalamanLaporanPinjaman()
    {
        return view('pages.laporan-pinjaman');
    }

    public function HalamanLaporanPenarikan()
    {
        return view('pages.laporan-penarikan');
    }
}
