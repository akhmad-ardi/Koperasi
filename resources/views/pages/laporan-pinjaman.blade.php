@extends('adminlte::page')

@section('title', 'Laporan Pinjaman')

@section('content_header')
    <h1>Laporan Pinjaman</h1>
@stop

@section('content')

    {{-- Filter tanggal + tombol --}}
    <div style="margin-bottom: 25px;"> {{-- jarak ke tabel --}}
        <form method="GET" action="{{ route('admin.laporan.pinjaman') }}">
            <div class="d-flex flex-wrap align-items-end" style="gap: 20px;">

                {{-- Dari tanggal --}}
                <div class="d-flex align-items-center">
                    <label for="start_date" class="fw-bold mb-0" style="margin-right: 8px;">Dari</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                        value="{{ request('start_date') }}">
                </div>

                {{-- Sampai tanggal --}}
                <div class="d-flex align-items-center">
                    <label for="end_date" class="fw-bold mb-0" style="margin-right: 8px;">Sampai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                        value="{{ request('end_date') }}">
                </div>


                {{-- Tombol --}}
                <div class="d-flex align-items-center">
                    <button type="submit" class="btn btn-success" style="margin-right: 12px;">
                        Filter
                    </button>
                    <a href="{{ route('admin.laporan.pinjaman') }}" class="btn btn-secondary" style="margin-right: 12px;">
                        Reset
                    </a>
                    <a href="{{ route('laporan.pinjaman.pdf', [
                        'start_date' => request('start_date'),
                        'end_date' => request('end_date'),
                    ]) }}"
                        class="btn btn-primary" target="_blank">
                        <i class="fa fa-download"></i> Unduh Laporan
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel laporan --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table id="angsuranTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Sekolah</th>
                                <th>Jumlah Pinjaman</th>
                                <th>Tanggal Angsuran</th>
                                <th>Angsuran Pokok</th>
                                <th>Jasa</th>
                                <th>Total Angsuran</th>
                                <th>Sisa Pinjaman</th>
                                <th>Status Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $totalPokok = 0;
                                $totalJasa = 0;
                                $totalAngsuran = 0;
                                $totalSisa = 0;
                            @endphp
                            @foreach ($anggota as $a)
                                @php
                                    $totalPinjaman = $a->pinjaman->sum('jumlah_pinjaman');
                                @endphp
                                @foreach ($a->angsuran as $angsuran)
                                    @php
                                        $totalPokok += $angsuran->jumlah_angsuran;
                                        $totalJasa += $angsuran->jasa;
                                        $totalAngsuran += $angsuran->jumlah_angsuran + $angsuran->jasa;
                                        $totalSisa += $angsuran->sisa_pinjaman;
                                        $status = $angsuran->sisa_pinjaman > 0 ? 'Belum Lunas' : 'Lunas';
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $a->no_anggota }}</td>
                                        <td>{{ $a->nama }}</td>
                                        <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                                        <td>Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($angsuran->tgl_angsuran)->format('d-m-Y') }}</td>
                                        <td>Rp {{ number_format($angsuran->jumlah_angsuran, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($angsuran->jasa, 0, ',', '.') }}</td>
                                        <td>Rp
                                            {{ number_format($angsuran->jumlah_angsuran + $angsuran->jasa, 0, ',', '.') }}
                                        </td>
                                        <td>Rp {{ number_format($angsuran->sisa_pinjaman, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="{{ $status == 'Lunas' ? 'bg-success text-white' : 'bg-danger text-white' }} px-2 py-1 rounded">
                                                {{ $status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-center">TOTAL</th>
                                <th>Rp {{ number_format($totalPokok, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalJasa, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalAngsuran, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalSisa, 0, ',', '.') }}</th>
                                <th>-</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        #angsuranTable th {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
        }

        #angsuranTable td {
            text-align: left;
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Laporan pinjaman per transaksi loaded');
    </script>
@stop
