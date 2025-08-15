@extends('adminlte::page')

@section('title', 'Tambah Simpanan')

@section('content_header')
    <h1>Tambah Data Simpanan</h1>
@stop


@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.tambah-simpanan') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <x-adminlte-select name="id_anggota" label="Nomor Anggota">
                                <option value="" selected disabled>Pilih Sekolah</option>
                                @foreach ($anggota as $a)
                                    <option value="{{ $a->id }}" data-nama="{{ $a->nama }}"
                                        {{ old('id') == $a->id ? 'selected' : '' }}>
                                        {{ $a->no_anggota }} | {{ $a->nama }}</option>
                                @endforeach
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="nama" label="Nama Anggota" type="text" placeholder="Nama Anggta"
                                value="{{ old('nama') }}" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tgl_simpanan" label="Tanggal Simpanan" type="date"
                                placeholder="Tanggal Simmpanan" value="{{ date('Y-m-d') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-select name="jenis_simpanan" label="Jenis Simpanan">
                                <option value="" selected disabled>Jenis Simpanan</option>
                                <option value="pokok" {{ old('jenis_simpanan') == 'pokok' ? 'selected' : '' }}>
                                    Pokok
                                </option>
                                <option value="wajib" {{ old('jenis_simpanan') == 'wajib' ? 'selected' : '' }}>
                                    Wajib
                                </option>
                                <option value="sukarela" {{ old('jenis_simpanan') == 'sukarela' ? 'selected' : '' }}>
                                    Sukarela
                                </option>
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_simpanan" label="Jumlah Simpanan" type="number"
                                placeholder="Jumlah Simpanan" value="{{ old('jumlah_simpanan') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="keterangan" label="Keterangan" type="text" placeholder="Keterangan"
                                value="{{ old('keterangan') }}" />
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
        document.getElementById('id_anggota').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];
            let nama = selected.getAttribute('data-nama');
            document.getElementById('nama').value = nama ?? '';
        });
    </script>
@stop
