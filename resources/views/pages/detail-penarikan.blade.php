@extends('adminlte::page')

@section('title', 'Simpanan')

@section('content_header')
    <h1>Data Simpanan</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3 justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="mb-3">
                        <x-adminlte-input name="no_anggota" label="Nomor Anggota" type="text" placeholder="Nama Anggta"
                            value="{{ $anggota->no_anggota }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                            value="{{ $anggota->nama }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="penarikan_pokok" label="Total Penarikan Pokok" type="text"
                            placeholder="Total Penarikan Pokok" value="{{ $penarikan_pokok }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="penarikan_wajib" label="Total Penarikan Wajib" type="text"
                            placeholder="Total Penarikan Wajib" value="{{ $penarikan_wajib }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="penarikan_sukarela" label="Total Penarikan Sukarela" type="text"
                            placeholder="Total Penarikan Sukarela" value="{{ $penarikan_sukarela }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.penarikan') }}" class="btn btn-danger">
                <i class="fa fa-fw fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.tambah-penarikan') }}" class="btn btn-primary">
                <i class="fa fa-fw fa-plus"></i>
                Tambah Penarikan
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
                                <th class="text-center">Tanggal Simpanan</th>
                                <th class="text-center">Jenis Simpanan</th>
                                <th class="text-center">Jumlah Simpanan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->penarikan as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->tgl_penarikan }}</td>
                                    <td>{{ $p->jenis_simpanan }}</td>
                                    <td>{{ $p->jumlah_penarikan }}</td>
                                    <td>
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapus{{ $p->id }}" />

                                        <x-adminlte-modal id="modalHapus{{ $p->id }}" title="Hapus Data"
                                            theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <x-slot name="footerSlot">
                                                <form
                                                    action="{{ route('delete.hapus-penarikan', ['id_penarikan' => $p->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-adminlte-button type="button" theme="outline-danger"
                                                        label="Batal Hapus" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="danger"
                                                        icon="fas fa-fw fa-trash" label="Hapus" />
                                                </form>
                                            </x-slot>
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
