<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $simpanan = Simpanan::select(
            'simpanan.id_anggota',
            'simpanan.jenis_simpanan',
            DB::raw('SUM(simpanan.jumlah_simpanan) - COALESCE(SUM(penarikan.jumlah_penarikan), 0) AS total_simpanan')
        )
            ->leftJoin('penarikan', function ($join) {
                $join->on('simpanan.id_anggota', '=', 'penarikan.id_anggota')
                    ->on('simpanan.jenis_simpanan', '=', 'penarikan.jenis_simpanan');
            })
            ->groupBy('simpanan.id_anggota', 'simpanan.jenis_simpanan')
            ->with('anggota') // biar bisa ambil nama/no anggota
            ->get();

        foreach ($simpanan as $s) {
            $s->total_simpanan = Helper::stringToRupiah($s->total_simpanan);
        }

        return view('pages.simpanan', [
            'simpanan' => $simpanan
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
            'jenis_simpanan' => ['required', 'in:pokok,wajib,sukarela'],
            'jumlah_simpanan' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $simpanan = Simpanan::updateOrCreate(
            [
                'id_anggota' => $validated['id_anggota'],
                'jenis_simpanan' => $validated['jenis_simpanan'],
            ],
            [
                'tgl_simpanan' => $validated['tgl_simpanan'],
                'keterangan' => $validated['keterangan'],
            ]
        );

        // Tambahkan jumlah simpanan baru
        $simpanan->jumlah_simpanan = ($simpanan->jumlah_simpanan ?? 0) + $validated['jumlah_simpanan'];
        $simpanan->save();

        return redirect()
            ->route('admin.anggota')
            ->with('msg_success', 'Simapan Berhasil Ditambahkan');
    }

    public function HalamanDetailSimpanan(string $id_anggota)
    {
        $data = Simpanan::select('jenis_simpanan', \DB::raw('SUM(jumlah_simpanan) as total'))
            ->where('id_anggota', $id_anggota)
            ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
            ->groupBy('jenis_simpanan')
            ->pluck('total', 'jenis_simpanan');

        // Ambil nilai dengan default 0 jika tidak ada
        $total_simpanan_pokok = $data['pokok'] ?? 0;
        $total_simpanan_wajib = $data['wajib'] ?? 0;
        $total_simpanan_sukarela = $data['sukarela'] ?? 0;

        $simpanan = Simpanan::where("id_anggota", "=", $id_anggota)->get();

        foreach ($simpanan as $s) {
            $s->tgl_simpanan = Helper::getTanggalAttribute($s->tgl_simpanan);
            $s->jumlah_simpanan = Helper::stringToRupiah($s->jumlah_simpanan);
        }

        return view("pages.detail-simpanan", [
            "total_simpanan_pokok" => Helper::stringToRupiah($total_simpanan_pokok),
            "total_simpanan_wajib" => Helper::stringToRupiah($total_simpanan_wajib),
            "total_simpanan_sukarela" => Helper::stringToRupiah($total_simpanan_sukarela),
            "simpanan" => $simpanan
        ]);
    }

    public function HalamanPinjaman()
    {
        $pinjaman = Pinjaman::withSum([
            'angsuran as total_angsuran_lunas' => function ($query) {
                $query->where('status', 'lunas');
            }
        ], 'total_angsuran')->get();

        foreach ($pinjaman as $p) {
            $p->jumlah_pinjaman = Helper::stringToRupiah($p->jumlah_pinjaman - $p->total_angsuran_lunas);
        }

        return view("pages.pinjaman", [
            'pinjaman' => $pinjaman
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
        ]);

        $pinjaman = Pinjaman::firstOrCreate(
            ['id_anggota' => $validated['id_anggota']], // cek berdasarkan id_anggota
            [ // default kalau belum ada
                'tgl_pinjaman' => $validated['tgl_pinjaman'],
                'jaminan' => $validated['jaminan'],
                'jumlah_pinjaman' => 0, // mulai dari 0 supaya bisa ditambah
            ]
        );

        // tambahkan jumlah pinjaman baru
        $pinjaman->jumlah_pinjaman += $validated['jumlah_pinjaman'];
        $pinjaman->tgl_pinjaman = $validated['tgl_pinjaman'];
        $pinjaman->jaminan = $validated['jaminan'];
        $pinjaman->save();

        return redirect()
            ->route('admin.pinjaman')
            ->with('msg_success', 'Pinjaman Berhasil Ditambahkan');
    }

    public function HalamanDetailPinjaman(string $id_pinjaman)
    {
        $detail_pinjaman = Pinjaman::where('id', '=', $id_pinjaman)->first();

        $detail_pinjaman->angsuran = $detail_pinjaman->angsuran->sortByDesc('angsuran_ke');

        foreach ($detail_pinjaman->angsuran as $a) {
            $a->tgl_angsuran = Helper::getTanggalAttribute($a->tgl_angsuran);
            $a->jumlah_angsuran = Helper::stringToRupiah($a->jumlah_angsuran);
            $a->total_angsuran = Helper::stringToRupiah($a->total_angsuran);
            $a->jasa = Helper::stringToRupiah($a->jasa);
        }

        $detail_pinjaman->jumlah_pinjaman = Helper::stringToRupiah($detail_pinjaman->jumlah_pinjaman);

        return view("pages.detail-pinjaman", [
            'detail_pinjaman' => $detail_pinjaman
        ]);
    }

    public function HalamanBayarAngsuran(string $id_pinjaman)
    {
        $angsuran = Angsuran::where('id_pinjaman', '=', $id_pinjaman)->first();

        $total_angsuran = Angsuran::where('id_pinjaman', $id_pinjaman)
            ->where('status', 'lunas')
            ->sum('total_angsuran');

        $angsuran->pinjaman->jumlah_pinjaman = Helper::stringToRupiah($angsuran->pinjaman->jumlah_pinjaman - $total_angsuran);

        return view('pages.bayar-angsuran', [
            'angsuran' => $angsuran
        ]);
    }

    public function BayarAngsuran(Request $request, string $id_pinjaman)
    {
        $validated = $request->validate([
            'tgl_angsuran' => ['required', 'date'],
            'jumlah_angsuran' => ['required', 'numeric', 'min:1'],
            'status' => ['required', 'in:lunas,belum lunas'],
        ]);

        $pinjaman = Pinjaman::find($id_pinjaman)->first();

        $jasa = $pinjaman->jumlah_pinjaman * 0.03;
        $total_angsuran = $validated['jumlah_angsuran'] + $jasa;

        Angsuran::create([
            'id_pinjaman' => $id_pinjaman,
            'tgl_angsuran' => $validated['tgl_angsuran'],
            'jumlah_angsuran' => $validated['jumlah_angsuran'],
            'jasa' => $jasa,
            'total_angsuran' => $total_angsuran,
            'status' => $validated['status']
        ]);

        return redirect()
            ->route('admin.detail-pinjaman', ['id_pinjaman' => $id_pinjaman])
            ->with('msg_success', 'Berhasil Ditambahkan');
    }

    public function HalamanPenarikan()
    {
        $penarikan = Penarikan::all();

        $penarikan = $penarikan->sortByDesc('tgl_penarikan');

        foreach ($penarikan as $p) {
            $p->tgl_penarikan = Helper::getTanggalAttribute($p->tgl_penarikan);
            $p->jumlah_penarikan = Helper::stringToRupiah($p->jumlah_penarikan);
        }

        return view('pages.penarikan', [
            'penarikan' => $penarikan
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
            'keterangan' => 'nullable|string|max:255',
        ]);

        $simpanan = Simpanan::where('id', '=', $validated['id_anggota'])
            ->where('jenis_simpanan', '=', $validated['jenis_simpanan'])
            ->first();

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

    public function HalamanDetailPenarikan(string $id_anggota)
    {
        $data = Penarikan::select('jenis_simpanan', \DB::raw('SUM(jumlah_penarikan) as total'))
            ->where('id_anggota', $id_anggota)
            ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
            ->groupBy('jenis_simpanan')
            ->pluck('total', 'jenis_simpanan');

        // Ambil nilai dengan default 0 jika tidak ada
        $total_penarikan_pokok = $data['pokok'] ?? 0;
        $total_penarikan_wajib = $data['wajib'] ?? 0;
        $total_penarikan_sukarela = $data['sukarela'] ?? 0;

        $penarikan = Penarikan::where("id_anggota", "=", $id_anggota)->get();

        foreach ($penarikan as $s) {
            $s->tgl_penarikan = Helper::getTanggalAttribute($s->tgl_penarikan);
            $s->jumlah_penarikan = Helper::stringToRupiah($s->jumlah_penarikan);
        }

        return view("pages.detail-penarikan", [
            "total_penarikan_pokok" => Helper::stringToRupiah($total_penarikan_pokok),
            "total_penarikan_wajib" => Helper::stringToRupiah($total_penarikan_wajib),
            "total_penarikan_sukarela" => Helper::stringToRupiah($total_penarikan_sukarela),
            "penarikan" => $penarikan
        ]);
    }

    public function HalamanLaporanSimpanan()
    {
        $anggota = Anggota::with(['simpanan', 'penarikan'])->get();

        // hitung saldo akhir per anggota
        $anggota->map(function ($a) {
            $simpanan = $a->simpanan->sum('jumlah_simpanan');
            $penarikan = $a->penarikan->sum('jumlah_penarikan');
            $a->saldo = Helper::stringToRupiah($simpanan - $penarikan);
            $a->jumlah_simpanan = Helper::stringToRupiah($simpanan);
            $a->jumlah_penarikan = Helper::stringToRupiah($penarikan);
            return $a;
        });

        return view('pages.laporan-simpanan', [
            'anggota' => $anggota
        ]);
    }

    public function LaporanSimpananPDF()
    {
        $anggota = Anggota::with(['simpanan', 'penarikan'])->get();

        // hitung saldo akhir per anggota
        $anggota->map(function ($a) {
            $simpanan = $a->simpanan->sum('jumlah_simpanan');
            $penarikan = $a->penarikan->sum('jumlah_penarikan');
            $a->saldo = $simpanan - $penarikan;
            return $a;
        });

        $pdf = Pdf::loadView('laporan.simpanan', compact('anggota'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-simpanan.pdf');
    }

    public function HalamanLaporanPinjaman()
    {
        $anggota = Anggota::with(['pinjaman.angsuran'])->get()->map(function ($a) {
            $totalPinjaman = 0;
            $totalAngsuran = 0;

            if ($a->pinjaman) {
                $totalPinjaman = (float) $a->pinjaman->jumlah_pinjaman;
                $totalAngsuran = (float) $a->pinjaman->angsuran->sum('jumlah_angsuran');
            }

            $a->total_pinjaman = $totalPinjaman;
            $a->total_angsuran = $totalAngsuran;
            $a->sisa_pinjaman = $totalPinjaman - $totalAngsuran;

            return $a;
        });

        return view('pages.laporan-pinjaman', [
            'anggota' => $anggota
        ]);
    }

    public function LaporanPinjaman()
    {
        $anggota = Anggota::with(['pinjaman.angsuran'])->get()->map(function ($a) {
            $totalPinjaman = 0;
            $totalAngsuran = 0;

            if ($a->pinjaman) {
                $totalPinjaman = (float) $a->pinjaman->jumlah_pinjaman;
                $totalAngsuran = (float) $a->pinjaman->angsuran->sum('jumlah_angsuran');
            }

            $a->total_pinjaman = $totalPinjaman;
            $a->total_angsuran = $totalAngsuran;
            $a->sisa_pinjaman = $totalPinjaman - $totalAngsuran;

            return $a;
        });

        $pdf = Pdf::loadView('laporan.pinjaman', compact('anggota'));
        return $pdf->download('laporan-pinjaman.pdf');
    }

    public function HalamanLaporanPenarikan()
    {
        $anggota = Anggota::with('penarikan')->get()->map(function ($a) {
            $totalPenarikan = (float) $a->penarikan->sum('jumlah_penarikan');
            $a->total_penarikan = $totalPenarikan;
            return $a;
        });

        return view('pages.laporan-penarikan', [
            'anggota' => $anggota
        ]);
    }

    public function LaporanPenarikan()
    {
        $anggota = Anggota::with('penarikan')->get()->map(function ($a) {
            $totalPenarikan = (float) $a->penarikan->sum('jumlah_penarikan');
            $a->total_penarikan = $totalPenarikan;
            return $a;
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.penarikan', compact('anggota'));
        return $pdf->download('laporan-penarikan.pdf');
    }
}
