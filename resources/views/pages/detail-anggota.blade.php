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
                                <div class="mb-3 text-center">
                                    <img src="/storage/foto/{{ $anggota->foto_diri }}" alt="Foto Diri" width="250"
                                        height="300">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="no_anggota" label="Nomor Anggota" type="text"
                                        placeholder="Nomor Anggota" value="{{ $anggota->no_anggota }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                                        value="{{ $anggota->nama }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="jenis_kelamin" label="Jenis Kelamin" type="text"
                                        placeholder="Jenis Kelamin" value="{{ $anggota->jenis_kelamin }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="sekolah" label="Sekolah" type="text" placeholder="Sekolah"
                                        value="{{ $anggota->sekolah->nama_sekolah }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tgl_lahir" label="Tanggal Lahir" type="text"
                                        placeholder="Tanggal Lahir" value="{{ $anggota->tgl_lahir }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="pekerjaan" label="Pekerjaan" type="text"
                                        placeholder="Pekejaan" value="{{ $anggota->pekerjaan }}" disabled />
                                </div>


                                <div class="mb-3">
                                    <x-adminlte-input name="no_telepon" label="Nomor Telepon" type="text"
                                        placeholder="Nomor Telepon" value="{{ $anggota->no_telepon }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="alamat" label="Alamat" type="text" placeholder="Alamat"
                                        value="{{ $anggota->alamat }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nik" label="NIK" type="number"
                                        placeholder="Nomor Induk Kependudukan" value="{{ $anggota->nik }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nip" label="NIP" type="number"
                                        placeholder="Nomor Induk Pegawai" value="{{ $anggota->nip }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="status" label="Status" type="text" placeholder="Status"
                                        value="{{ $anggota->status }}" disabled />
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
