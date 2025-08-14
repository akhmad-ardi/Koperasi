@extends('adminlte::page')

@section('title', 'Laporan Pinjaman')

@section('content_header')
    <h1>Laporan Pinjaman</h1>
@stop

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">No. Anggota</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Pinjaman</th>
                                <th class="text-center">Jumlah Pinjaman</th>
                                <th class="text-center">Jasa</th>
                                <th class="text-center">Total Pinjaman</th>
                                <th class="text-center">Jaminan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>1</td>
                                <td>Ardi</td>
                                <td>31-12-2024</td>
                                <td>Rp 1.000.000</td>
                                <td>-</td>
                                <td>Rp 1.000.000</td>
                                <td>Smartphone</td>
                                <td>Belum Lunas</td>
                            </tr>
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
