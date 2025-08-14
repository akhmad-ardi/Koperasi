@extends('adminlte::page')

@section('title', 'Sekolah')

@section('content_header')
    <h1>Data Sekolah</h1>
@stop

@section('content')
    <div class="row">
        <div class="col">
            <a href="" class="btn btn-primary">
                <i class="fas fa-fw fa-plus"></i>
                Tambah Sekolah
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
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>SDIT Al-Ishlah Maros</td>
                                <td>Alamat</td>
                                <td class="text-center">
                                    <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                        data-toggle="modal" data-target="#modalEdit" />

                                    <x-adminlte-modal id="modalEdit" title="Edit Data" theme="primary"
                                        icon="fas fa-fw fa-pen" size='md'>
                                        <form action="">
                                            <div class="mb-3 text-left">
                                                <x-adminlte-input name="nama" label="Nama Sekolah"
                                                    placeholder="Nama Sekolah" disable-feedback />
                                            </div>
                                            <div class="mb-3 text-left">
                                                <x-adminlte-input name="alamat" label="Alamat Sekolah"
                                                    placeholder="Alamat Sekolah" disable-feedback />
                                            </div>
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button type="button" theme="outline-primary" label="Batal Edit"
                                                    data-dismiss="modal" />
                                                <x-adminlte-button type="submit" theme="primary" icon="fas fa-fw fa-trash"
                                                    label="Simpan Edit" />
                                            </x-slot>
                                        </form>
                                    </x-adminlte-modal>

                                    <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                        data-toggle="modal" data-target="#modalHapus" />

                                    <x-adminlte-modal id="modalHapus" title="Hapus Data" theme="danger"
                                        icon="fas fa-fw fa-trash" size='md'>
                                        <p>Apakah anda ingin menghapus data ini ?</p>
                                        <form action="">
                                            <x-slot name="footerSlot">
                                                <x-adminlte-button type="button" theme="outline-danger" label="Batal Hapus"
                                                    data-dismiss="modal" />
                                                <x-adminlte-button type="submit" theme="danger" icon="fas fa-fw fa-trash"
                                                    label="Hapus" />
                                            </x-slot>
                                        </form>
                                    </x-adminlte-modal>
                                </td>
                            </tr>
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
    <script>
        console.log('Dashboard Loaded');
    </script>
@stop
