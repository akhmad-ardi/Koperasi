@extends('adminlte::page')

@section('title', 'Tambah Sekolah')

@section('content_header')
    <h1>Tambah Data Sekolah</h1>
@stop


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="mb-3">
                            <x-adminlte-input name="nama" label="Nama Sekolah" placeholder="Nama Sekolah" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="alamat" label="Alamat Sekolah" placeholder="Alamat Sekolah" />
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.sekolah') }}" class="btn btn-outline-primary">Kembali</a>

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
