<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route("admin.dashboard");
});

Route::prefix("auth")->group(function () {
    Route::get("", function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'HalamanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');
});

Route::prefix("admin")->group(function () {
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
    });

    /**
     * Anggota
     */
    Route::prefix("anggota")->group(function () {
        Route::get("", [AdminController::class, "HalamanAnggota"])->name("admin.anggota");

        Route::get("/tambah", [AdminController::class, "HalamanTambahAnggota"])->name("admin.tambah-anggota");
    });

    /**
     * Simpanan
     */
    Route::prefix("simpanan")->group(function () {
        Route::get("", [AdminController::class, "HalamanSimpanan"])->name("admin.simpanan");

        Route::get("/tambah", [AdminController::class, "HalamanTambahSimpanan"])->name("admin.tambah-simpanan");
    });

    /**
     * Pinjaman
     */
    Route::prefix("pinjaman")->group(function () {
        Route::get("", [AdminController::class, "HalamanPinjaman"])->name("admin.pinjaman");

        Route::get("/tambah", [AdminController::class, "HalamanTambahPinjaman"])->name("admin.tambah-pinjaman");
    });

    /**
     * Angsuran
     */
    Route::prefix("angsuran")->group(function () {
        Route::get("", [])->name("admin.angsuran");

        Route::get("/tambah", [])->name("admin.tambah-angsuran");
    });

    /**
     * Penarikan
     */
    Route::prefix("penarikan")->group(function () {
        Route::get("", [AdminController::class, "HalamanPenarikan"])->name("admin.penarikan");

        Route::get("/tambah", [AdminController::class, "HalamanTambahPenarikan"])->name("admin.tambah-penarikan");
    });

    /**
     * Laporan
     */
    Route::prefix("laporan")->group(function () {
        Route::get("", function () {
            return redirect()->route("admin.laporan.simpanan");
        });

        Route::get("simpanan", [AdminController::class, 'HalamanLaporanSimpanan'])->name("admin.laporan.simpanan");

        Route::get("pinjaman", [AdminController::class, 'HalamanLaporanPinjaman'])->name("admin.laporan.pinjaman");

        Route::get("penarikan", [AdminController::class, 'HalamanLaporanPenarikan'])->name("admin.laporan.penarikan");
    });
});


