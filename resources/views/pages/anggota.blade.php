@extends('adminlte::page')

@section('title', 'Anggota')

@section('content_header')
    <h1>Data Anggota</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.tambah-anggota') }}" class="btn btn-primary">
                <i class="fas fa-fw fa-plus"></i>
                Tambah Anggota
            </a>
        </div>
    </div>

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
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Tanggal Gabung</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->sekolah->nama_sekolah }}</td>
                                    <td>{{ $a->jenis_kelamin }}</td>
                                    <td>{{ $a->tgl_lahir }}</td>
                                    <td class="text-center">
                                        {{-- Detail --}}
                                        <x-adminlte-button label="Detail" theme="info" icon="fas fa-fw fa-user"
                                            data-toggle="modal" data-target="#modalDetail" />

                                        <x-adminlte-modal id="modalDetail" title="Detail Data" theme="info"
                                            icon="fas fa-fw fa-user" size='md'>
                                            <form action="">
                                                <div class="mb-3 text-left">
                                                    <x-adminlte-input name="nama" label="Nama Sekolah"
                                                        placeholder="Nama Sekolah" />
                                                </div>
                                                <div class="mb-3 text-left">
                                                    <x-adminlte-input name="alamat" label="Alamat Sekolah"
                                                        placeholder="Alamat Sekolah" />
                                                </div>
                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button type="button" theme="outline-primary"
                                                        label="Batal Edit" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="primary"
                                                        icon="fas fa-fw fa-trash" label="Simpan Edit" />
                                                </x-slot>
                                            </form>
                                        </x-adminlte-modal>

                                        {{-- Edit --}}
                                        <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                            data-toggle="modal" data-target="#modalEdit" />

                                        <x-adminlte-modal id="modalEdit" title="Edit Data" theme="primary"
                                            icon="fas fa-fw fa-pen" size='lg' scrollable>
                                            <form action="">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <x-adminlte-input name="no_anggota" label="Nomor Anggota"
                                                                type="text" placeholder="Nomor Anggota" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="nama" label="Nama" type="text"
                                                                placeholder="Nama" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-select name="id_sekolah" label="Sekolah">
                                                                <option value="" selected disabled>Pilih Sekolah
                                                                </option>
                                                                <option value="1">Sekolah 1</option>
                                                                <option value="2">Sekolah 2</option>
                                                            </x-adminlte-select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-select name="jenis_kelamin" label="Jenis Kelamin">
                                                                <option value="" selected disabled>Pilih Jenis Kelamin
                                                                </option>
                                                                <option value="laki-laki">Laki-laki</option>
                                                                <option value="perempuan">Perempuan</option>
                                                            </x-adminlte-select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="tempat_lahir" label="Tempat Lahir"
                                                                type="text" placeholder="Tempat Lahir" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="tanggal_lahir" label="Tanggal Lahir"
                                                                type="date" placeholder="Tanggal Lahir" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <x-adminlte-input name="pekerjaan" label="Pekerjaan"
                                                                type="text" placeholder="Pekejaan" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="nomor_telepon" label="Nomor Telepon"
                                                                type="number" placeholder="Nomor Telepon" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="alamat" label="Alamat"
                                                                type="text" placeholder="Alamat" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="nik" label="NIK"
                                                                type="number" placeholder="Nomor Induk Kependudukan" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="nip" label="NIP"
                                                                type="number" placeholder="Nomor Induk Pegawai" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="foto_diri" label="Foto Diri"
                                                                type="file" accept="image/*"
                                                                placeholder="Foto Diri" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <x-adminlte-input name="status" label="Status"
                                                                type="text" placeholder="Status" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button type="button" theme="outline-primary"
                                                        label="Batal Edit" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="primary"
                                                        icon="fas fa-fw fa-trash" label="Simpan Edit" />
                                                </x-slot>
                                            </form>
                                        </x-adminlte-modal>

                                        {{-- Hapus --}}
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapus" />

                                        <x-adminlte-modal id="modalHapus" title="Hapus Data" theme="danger"
                                            icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <form action="">
                                                <x-slot name="footerSlot">
                                                    <x-adminlte-button type="button" theme="outline-danger"
                                                        label="Batal Hapus" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="danger"
                                                        icon="fas fa-fw fa-trash" label="Hapus" />
                                                </x-slot>
                                            </form>
                                        </x-adminlte-modal>
                                    </td>
                                </tr>
                            @endforeach
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
    @if (session('msg_success'))
        <script>
            toastr.success("{{ session('msg_success') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif
@stop
