@extends('adminlte::page')

@section('title', 'Laporan Pinjaman')

@section('content_header')
    <h1>Laporan Pinjaman</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('laporan.pinjaman.pdf') }}" class="btn btn-primary">
                <i class="fa fa-fw fa-download"></i>
                Unduh Laporan
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Sekolah</th>
                                <th>Total Pinjaman</th>
                                <th>Total Angsuran Pokok</th>
                                <th>Total Jasa</th>
                                <th>Total Angsuran</th>
                                <th>Sisa Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                                    <td>Rp {{ number_format($a->total_pinjaman, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($a->angsuran->sum('jumlah_angsuran'), 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($a->angsuran->sum('jasa'), 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($a->total_angsuran, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($a->sisa_pinjaman, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@section('css')
    <style>
        /* Header tabel */
        #anggotaTable th {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Isi tabel */
        #anggotaTable td {
            text-align: left;
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Dashboard Loaded');
    </script>
@stop
