@extends('adminlte::page')

@section('title', 'Simpanan')

@section('content_header')
    <h1>Data Simpanan</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.tambah-simpanan') }}" class="btn btn-primary">
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
                                <th class="text-center">Jenis Simpanan</th>
                                <th class="text-center">Jumlah Simpanan</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($simpanan as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $s->anggota->no_angggota }}</td>
                                    <td>{{ $s->anggota->nama }}</td>
                                    <td>{{ $s->jenis_simpanan }}</td>
                                    <td>{{ $s->jumlah_simpanan }}</td>
                                    <td>{{ $s->tgl_simpanan }}</td>
                                    <td class="text-center">
                                        {{-- Detail --}}
                                        <x-adminlte-button label="Detail" theme="info" icon="fas fa-fw fa-user"
                                            data-toggle="modal" data-target="#modalDetail" />

                                        {{-- Modal Detail --}}
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

                                        {{-- Modal Edit --}}
                                        <x-adminlte-modal id="modalEdit" title="Edit Data" theme="primary"
                                            icon="fas fa-fw fa-pen" size='lg' scrollable>
                                            <form action="">
                                                <div class="mb-3">
                                                    <x-adminlte-input name="nomor_anggota" label="Nomor Anggota"
                                                        type="number" placeholder="Nomor Anggota" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="nama" label="Nama Anggota" type="text"
                                                        placeholder="Nama Anggta" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="tanggal_simpanan" label="Tanggal Simpanan"
                                                        type="date" placeholder="Tanggal Simmpanan"
                                                        value="{{ date('Y-m-d') }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jenis_simpanan" label="Jenis Simpanan"
                                                        type="text" placeholder="Jenis Simpanan" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jumlah_penarikan" label="Jumlah Penarikan"
                                                        type="number" placeholder="Jumlah Penarikan" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="keterangan" label="Keterangan" type="text"
                                                        placeholder="Keterangan" />
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

                                        {{-- Modal Hapus --}}
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
