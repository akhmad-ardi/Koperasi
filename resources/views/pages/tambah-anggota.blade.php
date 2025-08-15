@extends('adminlte::page')

@section('title', 'Tambah Anggota')

@section('content_header')
    <h1>Tambah Data Anggota</h1>
@stop


@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.tambah-anggota') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="no_anggota" label="Nomor Anggota" type="text"
                                        placeholder="Nomor Anggota" value="{{ old('no_anggota') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                                        value="{{ old('nama') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-select name="id_sekolah" label="Sekolah">
                                        <option value="" selected disabled>Pilih Sekolah</option>
                                        @foreach ($sekolah as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('id_sekolah', $s->id_sekolah) == $s->id ? 'selected' : '' }}>
                                                {{ $s->nama_sekolah }}</option>
                                        @endforeach
                                    </x-adminlte-select>
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-select name="jenis_kelamin" label="Jenis Kelamin">
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="laki-laki"
                                            {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </x-adminlte-select>
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" type="text"
                                        placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tgl_lahir" label="Tanggal Lahir" type="date"
                                        placeholder="Tanggal Lahir" value="{{ old('tgl_lahir') }}" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="pekerjaan" label="Pekerjaan" type="text"
                                        placeholder="Pekejaan" value="{{ old('pekerjaan') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="no_telepon" label="Nomor Telepon" type="number"
                                        placeholder="Nomor Telepon" value="{{ old('no_telepon') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="alamat" label="Alamat" type="text" placeholder="Alamat"
                                        value="{{ old('alamat') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nik" label="NIK" type="number"
                                        placeholder="Nomor Induk Kependudukan" value="{{ old('nik') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nip" label="NIP" type="number"
                                        placeholder="Nomor Induk Pegawai" value="{{ old('nip') }}" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input-file name="foto_diri" label="Foto Diri" accept="image/*"
                                        placeholder="Upload Foto Diri" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="status" label="Status" type="text" placeholder="Status"
                                        value="{{ old('status') }}" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.anggota') }}" class="btn btn-outline-primary">Kembali</a>

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

@stop
