<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\LoginMiddleware;

Route::get('/', function () {
    return redirect()->route("admin.dashboard");
});

Route::get("/logout", [AuthController::class, 'logout'])->name('logout');

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
        });

        /**
         * Anggota
         */
        Route::prefix("anggota")->group(function () {
            Route::get("", [AdminController::class, "HalamanAnggota"])->name("admin.anggota");

            Route::get("/tambah", [AdminController::class, "HalamanTambahAnggota"])->name("admin.tambah-anggota");
            Route::post('/tambah', [AdminController::class, 'TambahAnggota'])->name('post.tambah-anggota');
        });

        /**
         * Simpanan
         */
        Route::prefix("simpanan")->group(function () {
            Route::get("", [AdminController::class, "HalamanSimpanan"])->name("admin.simpanan");

            Route::get("/tambah", [AdminController::class, "HalamanTambahSimpanan"])->name("admin.tambah-simpanan");
            Route::post('/tambah', [AdminController::class, 'TambahSimpanan'])->name('post.tambah-simpanan');
        });

        /**
         * Pinjaman
         */
        Route::prefix("pinjaman")->group(function () {
            Route::get("", [AdminController::class, "HalamanPinjaman"])->name("admin.pinjaman");

            Route::get("/tambah", [AdminController::class, "HalamanTambahPinjaman"])->name("admin.tambah-pinjaman");
            Route::post('/tambah', [AdminController::class, 'TambahPinjaman'])->name('post.tambah-pinjaman');

            Route::get("/detail/{id_pinjaman}", [AdminController::class, "HalamanDetailPinjaman"])->name("admin.detail-pinjaman");
            Route::get('/bayar-angsuran/{id_pinjaman}', [AdminController::class, "HalamanBayarAngsuran"])->name('admin.bayar-angsuran');
            Route::post('/bayar-angsuran/{id_pinjaman}', [AdminController::class, "BayarAngsuran"])->name('post.bayar-angsuran');
        });

        /**
         * Penarikan
         */
        Route::prefix("penarikan")->group(function () {
            Route::get("", [AdminController::class, "HalamanPenarikan"])->name("admin.penarikan");

            Route::get("/tambah", [AdminController::class, "HalamanTambahPenarikan"])->name("admin.tambah-penarikan");
            Route::post("/tambah", [AdminController::class, "TambahPenarikan"])->name("post.tambah-penarikan");
        });

        /**
         * Laporan
         */
        Route::prefix("laporan")->group(function () {
            Route::get("", function () {
                return redirect()->route("admin.laporan.simpanan");
            });

            Route::get("simpanan", [AdminController::class, 'HalamanLaporanSimpanan'])->name("admin.laporan.simpanan");
            Route::get('/simpanan/pdf', [AdminController::class, 'LaporanSimpananPDF'])
                ->name('laporan.simpanan.pdf');

            Route::get("pinjaman", [AdminController::class, 'HalamanLaporanPinjaman'])->name("admin.laporan.pinjaman");
            Route::get('/pinjaman/pdf', [AdminController::class, 'LaporanPinjaman'])->name('laporan.pinjaman.pdf');

            Route::get("/penarikan", [AdminController::class, 'HalamanLaporanPenarikan'])->name("admin.laporan.penarikan");
            Route::get("/penarikan/pdf", [AdminController::class, 'LaporanPenarikan'])->name("laporan.penarikan.pdf");
        });
    });


