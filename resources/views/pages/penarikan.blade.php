@extends('adminlte::page')

@section('title', 'Penarikan')

@section('content_header')
    <h1>Data Penarikan</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.tambah-penarikan') }}" class="btn btn-primary">
                <i class="fas fa-fw fa-plus"></i>
                Tambah Data
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
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">Jenis Simpanan</th>
                                <th class="text-center">Jumlah Penarikan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penarikan as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->anggota->no_anggota }}</td>
                                    <td>{{ $p->anggota->nama }}</td>
                                    <td>{{ $p->tgl_penarikan }}</td>
                                    <td>{{ $p->jenis_simpanan }}</td>
                                    <td>{{ $p->jumlah_penarikan }}</td>
                                    <td>{{ $p->keterangan }}</td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                            data-toggle="modal" data-target="#modalEdit" />

                                        <x-adminlte-modal id="modalEdit" title="Edit Data" theme="primary"
                                            icon="fas fa-fw fa-pen" size='md'>
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
    <script>
        console.log('Dashboard Loaded');
    </script>
@stop
