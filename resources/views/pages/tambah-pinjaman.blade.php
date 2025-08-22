@extends('adminlte::page')

@section('title', 'Tambah Pinajaman')

@section('content_header')
    <h1>Tambah Data Pinjaman</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.tambah-pinjaman') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <x-adminlte-select name="id_anggota" label="Nomor Anggota">
                                <option value="" selected disabled>Pilih Anggota</option>
                                @foreach ($anggota as $a)
                                    <option value="{{ $a->id }}" data-nama="{{ $a->nama }}"
                                        {{ old('id') == $a->id ? 'selected' : '' }}>
                                        {{ $a->no_anggota }} | {{ $a->nama }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="nama" label="Nama Anggota" type="text" placeholder="Nama Anggota"
                                disabled value="{{ old('nama') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tgl_pinjaman" label="Tanggal Pinjaman" type="date"
                                placeholder="Tanggal Pinjaman" value="{{ old('tgl_pinjaman') ?? date('Y-m-d') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jaminan" label="Jaminan" type="text" placeholder="Jaminan"
                                value="{{ old('jaminan') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_pinjaman" label="Jumlah Pinjaman" type="number"
                                placeholder="Jumlah Pinjaman" value="{{ old('jumlah_pinjaman') }}" />
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
        document.getElementById('id_anggota').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            let nama = selected.getAttribute('data-nama');
            document.getElementById('nama').value = nama ?? '';
        });
    </script>
@stop
