@extends('adminlte::page')

@section('title', 'Tambah Simpanan')

@section('content_header')
    <h1>Tambah Data Simpanan</h1>
@stop


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="nomor_anggota" label="Nomor Anggota" type="number"
                                        placeholder="Nomor Anggota" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nama" label="Nama Anggota" type="text"
                                        placeholder="Nama Anggta" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tanggal_pinjaman" label="Tanggal Pinjaman" type="date"
                                        placeholder="Tanggal Pinjaman" value="{{ date('Y-m-d') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="jaminan" label="Jaminan" type="text" placeholder="Jaminan" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="jumlah_pinjaman" label="Jumlah Pinjaman" type="number"
                                        placeholder="Jumlah Pinjaman" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="jasa" label="Jasa" type="text" placeholder="Jasa" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="total_pinjaman" label="Jumlah Pinjaman" type="text"
                                        placeholder="Jumlah Pinjaman" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.simpanan') }}" class="btn btn-outline-primary">Kembali</a>

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
