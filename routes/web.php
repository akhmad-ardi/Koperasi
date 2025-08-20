<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
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

        Route::get("/dashboard", [AdminController::class, "HalamanDashboard"])->name("admin.dashboard");

        /**
         * Sekolah
         */
        Route::prefix("sekolah")->group(function () {
            Route::get("", [AdminController::class, "HalamanSekolah"])->name("admin.sekolah");

            Route::get("/tambah", [AdminController::class, "HalamanTambahSekolah"])->name("admin.tambah-sekolah");
            Route::post('/tambah', [AdminController::class, 'TambahSekolah'])->name('post.tambah-sekolah');

            Route::put("/edit/{id}", [AdminController::class, 'EditSekolah'])->name('put.edit-sekolah');
            Route::delete("/hapus/{id}", [AdminController::class, 'HapusSekolah'])->name('delete.hapus-sekolah');
        })->middleware(AdminMiddleware::class);

        /**
         * Anggota
         */
        Route::prefix("anggota")->group(function () {
            Route::get("", [AdminController::class, "HalamanAnggota"])->name("admin.anggota");

            Route::get("/detail/{id_anggota}", [AdminController::class, "HalamanDetailAnggota"])->name("admin.detail-anggota");

            Route::get("/tambah", [AdminController::class, "HalamanTambahAnggota"])->name("admin.tambah-anggota");
            Route::post('/tambah', [AdminController::class, 'TambahAnggota'])->name('post.tambah-anggota');

            Route::get("/edit/{id_anggota}", [AdminController::class, "HalamanEditAnggota"])->name("admin.edit-anggota");
            Route::put("/edit/{id_anggota}", [AdminController::class, "EditAnggota"])->name("put.edit-anggota");

            Route::delete("/hapus/{id_anggota}", [AdminController::class, "HapusAnggota"])->name("delete.hapus-anggota");
        })->middleware(AdminMiddleware::class);

        /**
         * Simpanan
         */
        Route::prefix("simpanan")->group(function () {
            Route::get("", [AdminController::class, "HalamanSimpanan"])->name("admin.simpanan");

            Route::get("/detail/{id_anggota}", [AdminController::class, "HalamanDetailSimpanan"])->name("admin.detail-simpanan");

            Route::get("/tambah", [AdminController::class, "HalamanTambahSimpanan"])->name("admin.tambah-simpanan");
            Route::post('/tambah', [AdminController::class, 'TambahSimpanan'])->name('post.tambah-simpanan');
            Route::put("/edit/{id_simpanan}", [AdminController::class, "EditSimpanan"])->name("put.edit-simpanan");
            Route::delete("/hapus/{id_simpanan}", [AdminController::class, "HapusSimpanan"])->name('delete.hapus-simpanan');
        })->middleware(AdminMiddleware::class);

        /**
         * Pinjaman
         */
        Route::prefix("pinjaman")->group(function () {
            Route::get("", [AdminController::class, "HalamanPinjaman"])->name("admin.pinjaman");

            Route::get("/detail/{id_anggota}", [AdminController::class, "HalamanDetailPinjaman"])->name("admin.detail-pinjaman");

            Route::get("/tambah", [AdminController::class, "HalamanTambahPinjaman"])->name("admin.tambah-pinjaman");
            Route::post('/tambah', [AdminController::class, 'TambahPinjaman'])->name('post.tambah-pinjaman');
            Route::put("/edit/{id_pinjaman}", [AdminController::class, "EditPinjaman"])->name("put.edit-pinjaman");
            Route::delete("/hapus/{id_pinjaman}", [AdminController::class, "HapusPinjaman"])->name("delete.hapus-pinjaman");

            Route::get('/bayar-angsuran/{id_anggota}', [AdminController::class, "HalamanBayarAngsuran"])->name('admin.bayar-angsuran');
            Route::post('/bayar-angsuran/{id_anggota}', [AdminController::class, "BayarAngsuran"])->name('post.bayar-angsuran');
            Route::put("/edit-angsuran/{id_angsuran}", [AdminController::class, "EditAngsuran"])->name("put.edit-angsuran");
            Route::delete("/hapus-angsuran/{id_angsuran}", [AdminController::class, "HapusAngsuran"])->name('delete.hapus-angsuran');
        })->middleware(AdminMiddleware::class);

        /**
         * Penarikan
         */
        Route::prefix("penarikan")->group(function () {
            Route::get("", [AdminController::class, "HalamanPenarikan"])->name("admin.penarikan");

            Route::get("/detail/{id_anggota}", [AdminController::class, 'HalamanDetailPenarikan'])->name('admin.detail-penarikan');

            Route::get("/tambah", [AdminController::class, "HalamanTambahPenarikan"])->name("admin.tambah-penarikan");
            Route::post("/tambah", [AdminController::class, "TambahPenarikan"])->name("post.tambah-penarikan");
            Route::put("/edit/{id_penarikan}", [AdminController::class, "EditPenarikan"])->name("put.edit-penarikan");
            Route::delete("/hapus/{id_penarikan}", [AdminController::class, "HapusPenarikan"])->name('delete.hapus-penarikan');
        })->middleware(AdminMiddleware::class);

        /**
         * Laporan
         */
        Route::prefix("laporan")->group(function () {
            Route::get("", function () {
                return redirect()->route("admin.laporan.simpanan");
            });

            Route::get("simpanan", [AdminController::class, 'HalamanLaporanSimpanan'])->name("admin.laporan.simpanan");
            Route::get('/simpanan/pdf', [AdminController::class, 'LaporanSimpananPDF'])->name('laporan.simpanan.pdf');

            Route::get("pinjaman", [AdminController::class, 'HalamanLaporanPinjaman'])->name("admin.laporan.pinjaman");
            Route::get('/pinjaman/pdf', [AdminController::class, 'LaporanPinjaman'])->name('laporan.pinjaman.pdf');

            Route::get("/penarikan", [AdminController::class, 'HalamanLaporanPenarikan'])->name("admin.laporan.penarikan");
            Route::get("/penarikan/pdf", [AdminController::class, 'LaporanPenarikan'])->name("laporan.penarikan.pdf");
        });
    });


