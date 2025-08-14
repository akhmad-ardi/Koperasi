@extends('adminlte::page')

@section('title', 'Tambah Anggota')

@section('content_header')
    <h1>Tambah Data Anggota</h1>
@stop


@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="no_anggota" label="Nomor Anggota" type="text"
                                        placeholder="Nomor Anggota" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-select name="id_sekolah" label="Sekolah">
                                        <option value="" selected disabled>Pilih Sekolah</option>
                                        <option value="1">Sekolah 1</option>
                                        <option value="2">Sekolah 2</option>
                                    </x-adminlte-select>
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-select name="jenis_kelamin" label="Jenis Kelamin">
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </x-adminlte-select>
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" type="text"
                                        placeholder="Tempat Lahir" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="tanggal_lahir" label="Tanggal Lahir" type="date"
                                        placeholder="Tanggal Lahir" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <x-adminlte-input name="pekerjaan" label="Pekerjaan" type="text"
                                        placeholder="Pekejaan" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nomor_telepon" label="Nomor Telepon" type="number"
                                        placeholder="Nomor Telepon" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="alamat" label="Alamat" type="text" placeholder="Alamat" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nik" label="NIK" type="number"
                                        placeholder="Nomor Induk Kependudukan" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="nip" label="NIP" type="number"
                                        placeholder="Nomor Induk Pegawai" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="foto_diri" label="Foto Diri" type="file" accept="image/*"
                                        placeholder="Foto Diri" />
                                </div>

                                <div class="mb-3">
                                    <x-adminlte-input name="status" label="Status" type="text" placeholder="Status" />
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
    <script>
        console.log('Dashboard Loaded');
    </script>
@stop
