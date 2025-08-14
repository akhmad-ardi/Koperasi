<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function HalamanDashboard()
    {
        return view('pages.dashboard');
    }

    public function HalamanSekolah()
    {
        return view('pages.sekolah');
    }

    public function HalamanTambahSekolah()
    {
        return view('pages.tambah-sekolah');
    }

    public function HalamanAnggota()
    {
        return view('pages.anggota');
    }

    public function HalamanTambahAnggota()
    {
        return view("pages.tambah-anggota");
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
