<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LoginMiddleware;

Route::get('/', function () {
    return redirect()->route("admin.dashboard");
});

Route::get("/logout", [AuthController::class, 'logout'])
    ->middleware(AuthMiddleware::class)
    ->name('logout');

Route::prefix("auth")->group(function () {
    Route::get("", function () {
        return redirect()->route('login');
    })->middleware(LoginMiddleware::class);

    Route::get('/login', [AuthController::class, 'HalamanLogin'])->name('login')->middleware(LoginMiddleware::class);
    Route::post('/login', [AuthController::class, 'login'])->name('post.login')->middleware(LoginMiddleware::class);
});

Route::prefix("admin")
    ->middleware(AuthMiddleware::class)
    ->group(function () {
        Route::get("", function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get("/dashboard", [DashboardController::class, "HalamanDashboard"])->name("admin.dashboard");

        /**
         * Sekolah
         */
        Route::prefix("sekolah")->group(function () {
            Route::get("", [SekolahController::class, "HalamanSekolah"])->name("admin.sekolah");

            Route::get("/tambah", [SekolahController::class, "HalamanTambahSekolah"])->name("admin.tambah-sekolah");
            Route::post('/tambah', [SekolahController::class, 'TambahSekolah'])->name('post.tambah-sekolah');

            Route::put("/edit/{id}", [SekolahController::class, 'EditSekolah'])->name('put.edit-sekolah');
            Route::delete("/hapus/{id}", [SekolahController::class, 'HapusSekolah'])->name('delete.hapus-sekolah');
        })->middleware(AdminMiddleware::class);

        /**
         * Anggota
         */
        Route::prefix("anggota")->group(function () {
            Route::get("", [AnggotaController::class, "HalamanAnggota"])->name("admin.anggota");

            Route::get("/detail/{id_anggota}", [AnggotaController::class, "HalamanDetailAnggota"])->name("admin.detail-anggota");

            Route::get("/tambah", [AnggotaController::class, "HalamanTambahAnggota"])->name("admin.tambah-anggota");
            Route::post('/tambah', [AnggotaController::class, 'TambahAnggota'])->name('post.tambah-anggota');

            Route::get("/edit/{id_anggota}", [AnggotaController::class, "HalamanEditAnggota"])->name("admin.edit-anggota");
            Route::put("/edit/{id_anggota}", [AnggotaController::class, "EditAnggota"])->name("put.edit-anggota");

            Route::delete("/hapus/{id_anggota}", [AnggotaController::class, "HapusAnggota"])->name("delete.hapus-anggota");
        })->middleware(AdminMiddleware::class);

        /**
         * Simpanan
         */
        Route::prefix("simpanan")->group(function () {
            Route::get("", [SimpananController::class, "HalamanSimpanan"])->name("admin.simpanan");

            Route::get("/detail/{id_anggota}", [SimpananController::class, "HalamanDetailSimpanan"])->name("admin.detail-simpanan");

            Route::get("/tambah", [SimpananController::class, "HalamanTambahSimpanan"])->name("admin.tambah-simpanan");
            Route::post('/tambah', [SimpananController::class, 'TambahSimpanan'])->name('post.tambah-simpanan');

            Route::put("/edit/{id_simpanan}", [SimpananController::class, "EditSimpanan"])->name("put.edit-simpanan");
            Route::delete("/hapus/{id_simpanan}", [SimpananController::class, "HapusSimpanan"])->name('delete.hapus-simpanan');
        })->middleware(AdminMiddleware::class);

        /**
         * Pinjaman
         */
        Route::prefix("pinjaman")->group(function () {
            Route::get("", [PinjamanController::class, "HalamanPinjaman"])->name("admin.pinjaman");

            Route::get("/detail/{id_anggota}", [PinjamanController::class, "HalamanDaftarPinjamanAnggota"])->name("admin.daftar-pinjaman-anggota");

            Route::get("/tambah", [PinjamanController::class, "HalamanTambahPinjaman"])->name("admin.tambah-pinjaman");
            Route::post('/tambah', [PinjamanController::class, 'TambahPinjaman'])->name('post.tambah-pinjaman');

            Route::get("/edit/{id_pinjaman}", [PinjamanController::class, "HalamanEditPinjaman"])->name("admin.edit-pinjaman");
            Route::put("/edit/{id_pinjaman}", [PinjamanController::class, "EditPinjaman"])->name("put.edit-pinjaman");

            Route::delete("/hapus/{id_pinjaman}", [PinjamanController::class, "HapusPinjaman"])->name("delete.hapus-pinjaman");

            Route::prefix("angsuran")->group(function () {
                Route::get("/{id_pinjaman}", [AngsuranController::class, "HalamanDetailPinjaman"])->name('admin.detail-pinjaman');

                Route::get('/tambah/{id_pinjaman}', [AngsuranController::class, "HalamanTambahAngsuran"])->name('admin.tambah-angsuran');
                Route::post('/tambah/{id_pinjaman}', [AngsuranController::class, "TambahAngsuran"])->name('post.tambah-angsuran');

                Route::put("/edit/{id_angsuran}", [AngsuranController::class, "EditAngsuran"])->name("put.edit-angsuran");
                Route::delete("/hapus-angsuran/{id_angsuran}", [AngsuranController::class, "HapusAngsuran"])->name('delete.hapus-angsuran');
            });
        })->middleware(AdminMiddleware::class);

        /**
         * Penarikan
         */
        Route::prefix("penarikan")->group(function () {
            Route::get("", [PenarikanController::class, "HalamanPenarikan"])->name("admin.penarikan");

            Route::get("/detail/{id_anggota}", [PenarikanController::class, 'HalamanDetailPenarikan'])->name('admin.detail-penarikan');

            Route::get("/tambah", [PenarikanController::class, "HalamanTambahPenarikan"])->name("admin.tambah-penarikan");
            Route::post("/tambah", [PenarikanController::class, "TambahPenarikan"])->name("post.tambah-penarikan");
            Route::put("/edit/{id_penarikan}", [PenarikanController::class, "EditPenarikan"])->name("put.edit-penarikan");
            Route::delete("/hapus/{id_penarikan}", [PenarikanController::class, "HapusPenarikan"])->name('delete.hapus-penarikan');
        })->middleware(AdminMiddleware::class);

        /**
         * Laporan
         */
        Route::prefix("laporan")->group(function () {
            Route::get("", function () {
                return redirect()->route("admin.laporan.simpanan");
            });

            Route::get("simpanan", [LaporanController::class, 'HalamanLaporanSimpanan'])->name("admin.laporan.simpanan");
            Route::get('/simpanan/pdf', [LaporanController::class, 'LaporanSimpananPDF'])->name('laporan.simpanan.pdf');

            Route::get("pinjaman", [LaporanController::class, 'HalamanLaporanPinjaman'])->name("admin.laporan.pinjaman");
            Route::get('/pinjaman/pdf', [LaporanController::class, 'LaporanPinjaman'])->name('laporan.pinjaman.pdf');

            Route::get("/penarikan", [LaporanController::class, 'HalamanLaporanPenarikan'])->name("admin.laporan.penarikan");
            Route::get("/penarikan/pdf", [LaporanController::class, 'LaporanPenarikan'])->name("laporan.penarikan.pdf");
        });
    });


