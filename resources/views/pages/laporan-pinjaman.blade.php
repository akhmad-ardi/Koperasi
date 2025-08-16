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
                                <th>No</th>
                                <th>No. Anggota</th>
                                <th>Nama Anggota</th>
                                <th>Total Pinjaman</th>
                                <th>Total Angsuran</th>
                                <th>Sisa Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }} </td>
                                    <td>{{ $a->nama }}</td>
                                    <td>Rp {{ number_format($a->total_pinjaman, 0, ',', '.') }}</td>
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
    {{-- Tambahkan CSS custom kalau perlu --}}
@stop

@section('js')
    <script>
        console.log('Dashboard Loaded');
    </script>
@stop
