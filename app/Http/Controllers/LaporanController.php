<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Anggota;
use App\Models\Simpanan;
use App\Models\Penarikan;

class LaporanController extends Controller
{
    public function HalamanLaporanSimpanan(Request $request)
    {
        $query = Simpanan::with(['anggota.sekolah']);

        // filter tanggal jika ada input
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_simpanan', [$request->start_date, $request->end_date]);
        }

        $simpanan = $query->orderBy('tgl_simpanan', 'asc')->get();

        return view('pages.laporan-simpanan', [
            'simpanan' => $simpanan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }

    public function LaporanSimpananPDF(Request $request)
    {
        $query = Simpanan::with(['anggota.sekolah']);

        // filter tanggal jika ada input
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_simpanan', [$request->start_date, $request->end_date]);
        }

        $simpanan = $query->orderBy('tgl_simpanan', 'asc')->get();

        $pdf = Pdf::loadView('laporan.simpanan', [
            'simpanan' => $simpanan,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ])

            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-simpanan.pdf');
    }

    public function HalamanLaporanPinjaman(Request $request)
    {
        $anggota = Anggota::with(['pinjaman.angsuran'])->get();

        return view('pages.laporan-pinjaman', compact('anggota'));
    }

    public function LaporanPinjaman(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Ambil data dengan filter tanggal
        $anggota = Anggota::with(['pinjaman.angsuran'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereHas('pinjaman.angsuran', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tgl_angsuran', [$startDate, $endDate]);
                });
            })
            ->get();

        $pdf = Pdf::loadView('laporan.pinjaman', compact('anggota', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pinjaman.pdf');
    }

    public function HalamanLaporanPenarikan(Request $request)
    {
        // Ambil data penarikan dengan relasi anggota & sekolah
        $penarikan = Penarikan::with(['anggota', 'anggota.sekolah'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('tgl_penarikan', [$request->start_date, $request->end_date]);
            })
            ->get();

        // Ambil tanggal untuk input form
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';

        return view('pages.laporan-penarikan', compact('penarikan', 'start_date', 'end_date'));
    }

    public function LaporanPenarikan(Request $request)
    {
        $penarikan = Penarikan::with(['anggota', 'anggota.sekolah'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('tgl_penarikan', [$request->start_date, $request->end_date]);
            })
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'laporan.penarikan',  // pastikan ini view khusus PDF penarikan
            compact('penarikan')
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penarikan.pdf');
    }
}
