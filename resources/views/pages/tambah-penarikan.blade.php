@extends('adminlte::page')

@section('title', 'Tambah Penarikan')

@section('content_header')
    <h1>Tambah Data Penarikan</h1>
@stop


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="mb-3">
                            <x-adminlte-input name="nomor_anggota" label="Nomor Anggota" type="number"
                                placeholder="Nomor Anggota" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="nama" label="Nama Anggota" type="text"
                                placeholder="Nama Anggota" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tanggal_penarikan" label="Tanggal Penarikan" type="date"
                                placeholder="Tanggal Penarikan" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jenis_simpanan" label="Jenis Simpanan" type="text"
                                placeholder="Jenis Simpanan" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_penarikan" label="Jumlah Penarikan" type="number"
                                placeholder="Jumlah Penarikan" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="keterangan" label="Keterangan" type="text"
                                placeholder="Keterangan" />
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.penarikan') }}" class="btn btn-outline-primary">Kembali</a>

                            <x-adminlte-button type="submit" theme="primary" label="Simpan" />
                        </div>
                    </form>
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
