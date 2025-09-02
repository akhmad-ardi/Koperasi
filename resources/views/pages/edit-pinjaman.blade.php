@extends('adminlte::page')

@section('title', 'Edit Pinajaman')

@section('content_header')
    <h1>Edit Data Pinjaman</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('put.edit-pinjaman', ['id_pinjaman' => $pinjaman->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <x-adminlte-input name="nomor" label="Nomor Anggota" type="text"
                                placeholder="Nomor Anggota" disabled value="{{ $pinjaman->anggota->no_anggota }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="nama" label="Nama Anggota" type="text" placeholder="Nama Anggota"
                                disabled value="{{ $pinjaman->anggota->nama }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tgl_pinjaman" label="Tanggal Pinjaman" type="date"
                                placeholder="Tanggal Pinjaman" value="{{ $pinjaman->tgl_pinjaman ?? date('Y-m-d') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jaminan" label="Jaminan" type="text" placeholder="Jaminan"
                                value="{{ $pinjaman->jaminan }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_pinjaman" label="Jumlah Pinjaman" type="number"
                                placeholder="Jumlah Pinjaman" value="{{ $pinjaman->jumlah_pinjaman }}" />
                        </div>

                        {{-- Tambahan untuk tenor --}}
                        <div class="mb-3">
                            <x-adminlte-input name="tenor" label="Tenor (Bulan)" type="number"
                                placeholder="Tenor dalam bulan" value="{{ $pinjaman->tenor }}" />
                        </div>

                        {{-- Tambahan untuk jatuh tempo --}}
                        <div class="mb-3">
                            <x-adminlte-input name="jatuh_tempo" label="Jatuh Tempo" type="date"
                                placeholder="Tanggal Jatuh Tempo" value="{{ $pinjaman->jatuh_tempo }}" />
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.pinjaman') }}" class="btn btn-outline-primary">Kembali</a>

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
        document.addEventListener("DOMContentLoaded", function() {
            const tglPinjaman = document.querySelector('input[name="tgl_pinjaman"]');
            const tenor = document.querySelector('input[name="tenor"]');
            const jatuhTempo = document.querySelector('input[name="jatuh_tempo"]');

            tenor.addEventListener("input", function() {
                if (tglPinjaman.value && tenor.value) {
                    let tgl = new Date(tglPinjaman.value);
                    tgl.setMonth(tgl.getMonth() + parseInt(tenor.value));
                    jatuhTempo.value = tgl.toISOString().split('T')[0];
                }
            });
        });
    </script>
@stop
