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
        $total_simpanan = Helper::stringToRupiah(Simpanan::sum('jumlah_simpanan') - Penarikan::sum('jumlah_penarikan'));
        $total_pinjaman = Helper::stringToRupiah(Pinjaman::sum('jumlah_pinjaman'));
        $total_angsuran = Helper::stringToRupiah(Angsuran::sum('total_angsuran'));
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

    public function HalamanSekolah(Request $request)
    {
        $keyword = $request->input('nama');

        // query sekolah
        $sekolahQuery = Sekolah::query();

        if (!empty($keyword)) {
            $sekolahQuery->where('nama_sekolah', 'LIKE', "%{$keyword}%");
        }

        // ambil semua anggota sesuai filter
        $sekolah = $sekolahQuery->get();

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
        $anggota = Anggota::where('id', '=', $id_anggota)->first();

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
            $total_pinjaman = $a->pinjaman->sum('jumlah_pinjaman');
            $total_angsuran = $a->angsuran->
                where('status', '=', 'lunas')
                ->sum('total_angsuran');

            $a->total_pinjaman = Helper::stringToRupiah($total_pinjaman - $total_angsuran);
        }

        return view("pages.pinjaman", [
            'anggota' => $anggota
        ]);
    }

    public function HalamanDetailPinjaman(string $id_anggota)
    {
        $anggota = Anggota::where('id', '=', $id_anggota)->first();
        $total_pinjaman = $anggota->pinjaman->sum('jumlah_pinjaman');
        $jumlah_angsuran = $anggota->angsuran->sum('jumlah_angsuran');

        $anggota->angsuran = $anggota->angsuran->sortBy('angsuran_ke');

        foreach ($anggota->angsuran as $a) {
            $a->jumlah_angsuran_rupiah = Helper::stringToRupiah($a->jumlah_angsuran);
            $a->total_angsuran_rupiah = Helper::stringToRupiah($a->total_angsuran);
            $a->jasa_rupiah = Helper::stringToRupiah($a->jasa);
            $a->tgl_angsuran_dmy = Helper::getTanggalAttribute($a->tgl_angsuran);
        }

        foreach ($anggota->pinjaman as $p) {
            $p->jumlah_pinjaman_rupiah = Helper::stringToRupiah($p->jumlah_pinjaman);
            $p->tgl_pinjaman_dmy = Helper::getTanggalAttribute($p->tgl_pinjaman);
        }

        return view("pages.detail-pinjaman", [
            'anggota' => $anggota,
            'total_pinjaman' => Helper::stringToRupiah($total_pinjaman - $jumlah_angsuran),
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

        Pinjaman::create($validated);

        return redirect()
            ->route('admin.pinjaman')
            ->with('msg_success', 'Pinjaman Berhasil Ditambahkan');
    }

    public function EditPinjaman(Request $request, string $id_pinjaman)
    {
        $validated = $request->validate([
            'tgl_pinjaman' => 'required|date',
            'jaminan' => 'nullable|string|max:255',
            'jumlah_pinjaman' => 'required|numeric|min:1',
        ]);

        $pinjaman = Pinjaman::where("id", "=", $id_pinjaman)->first();
        if (!$pinjaman->update($validated)) {
            return redirect()
                ->route("admin.detail-pinjaman", ['id_anggota' => $pinjaman->id_anggota])
                ->with('msg_error', 'Pinjaman Gagal Diubah');
        }

        return redirect()
            ->route("admin.detail-pinjaman", ['id_anggota' => $pinjaman->id_anggota])
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

    public function HalamanBayarAngsuran(string $id_anggota)
    {
        $anggota = Anggota::where('id', '=', $id_anggota)
            ->first();

        $total_pinjaman = $anggota->pinjaman->sum('jumlah_pinjaman');
        $total_angsuran = $anggota->angsuran->sum('jumlah_angsuran');

        return view('pages.bayar-angsuran', [
            'anggota' => $anggota,
            'total_pinjaman' => Helper::stringToRupiah($total_pinjaman - $total_angsuran)
        ]);
    }

    public function BayarAngsuran(Request $request, string $id_anggota)
    {
        $validated = $request->validate([
            'tgl_angsuran' => ['required', 'date'],
            'jumlah_angsuran' => ['required', 'numeric', 'min:1'],
        ]);

        $anggota = Anggota::where("id", '=', $id_anggota)->first();

        $jumlah_pinjaman = $anggota->pinjaman->sum('jumlah_pinjaman');
        $jumlah_angsuran = $anggota->angsuran->sum('jumlah_angsuran');

        $sisa_pinjaman = $jumlah_pinjaman - $jumlah_angsuran;

        $jasa = $sisa_pinjaman * 0.03;
        $total_angsuran = $validated['jumlah_angsuran'] + $jasa;

        Angsuran::create([
            'id_anggota' => $id_anggota,
            'tgl_angsuran' => $validated['tgl_angsuran'],
            'jumlah_angsuran' => $validated['jumlah_angsuran'],
            'jasa' => $jasa,
            'total_angsuran' => $total_angsuran,
        ]);

        return redirect()
            ->route('admin.detail-pinjaman', ['id_anggota' => $id_anggota])
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
        $anggota = Anggota::where("id", '=', $angsuran->id_anggota)->first();

        $jumlah_pinjaman = $anggota->pinjaman->sum('jumlah_pinjaman');
        $jumlah_angsuran = $anggota->angsuran->sum('jumlah_angsuran');

        $sisa_pinjaman = $jumlah_pinjaman - $jumlah_angsuran;

        $jasa = $sisa_pinjaman * 0.03;
        $total_angsuran = $validated['jumlah_angsuran'] + $jasa;

        $angsuran->update([
            'tgl_angsuran' => $validated['tgl_angsuran'],
            'jumlah_angsuran' => $validated['jumlah_angsuran'],
            'jasa' => $jasa,
            'total_angsuran' => $total_angsuran
        ]);

        return redirect()
            ->route("admin.detail-pinjaman", ["id_anggota" => $anggota->id])
            ->with("msg_success", "Angsuran Berhasil Diubah");
    }

    public function HapusAngsuran(string $id_angsuran)
    {
        $angsuran = Angsuran::where("id", '=', $id_angsuran)->first();
        if (!$angsuran || !$angsuran->delete()) {
            return redirect()
                ->route('admin.detail-pinjaman', ['id_anggota' => $angsuran->id_anggota])
                ->with('msg_error', "Gagal menghapus angsuran");
        }

        return redirect()
            ->route('admin.detail-pinjaman', ['id_anggota' => $angsuran->id_anggota])
            ->with('msg_success', "Berhasil menghapus angsuran");
    }

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
        $anggota = Anggota::where('id', '=', $id_anggota)->first();

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
        $anggota = Anggota::with(['pinjaman', 'angsuran'])->get()->map(function ($a) {
            $totalPinjaman = $a->pinjaman->sum('jumlah_pinjaman');
            $jumlahAngsuran = $a->angsuran->sum('jumlah_angsuran');
            $totalAngsuran = $a->angsuran->sum('total_angsuran');

            $a->total_pinjaman = (float) $totalPinjaman;
            $a->total_angsuran = (float) $totalAngsuran;
            $a->sisa_pinjaman = (float) $totalPinjaman - (float) $jumlahAngsuran;

            return $a;
        });

        return view('pages.laporan-pinjaman', [
            'anggota' => $anggota
        ]);
    }

    public function LaporanPinjaman()
    {
        $anggota = Anggota::with(['pinjaman', 'angsuran'])->get()->map(function ($a) {
            $totalPinjaman = $a->pinjaman->sum('jumlah_pinjaman');
            $jumlahAngsuran = $a->angsuran->sum('jumlah_angsuran');
            $totalAngsuran = $a->angsuran->sum('total_angsuran');

            $a->total_pinjaman = (float) $totalPinjaman;
            $a->total_angsuran = (float) $totalAngsuran;
            $a->sisa_pinjaman = (float) $totalPinjaman - (float) $jumlahAngsuran;

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
