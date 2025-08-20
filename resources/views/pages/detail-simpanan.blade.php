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
                        <x-adminlte-input name="simpanan_pokok" label="Total Simpanan Pokok" type="text"
                            placeholder="Total Simpanan Pokok" value="{{ $simpanan_pokok }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="simpanan_wajib" label="Total Simpanan Wajib" type="text"
                            placeholder="Total Simpanan Wajib" value="{{ $simpanan_wajib }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="simpanan_sukarela" label="Total Simpanan Sukarela" type="text"
                            placeholder="Total Simpanan Sukarela" value="{{ $simpanan_sukarela }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.simpanan') }}" class="btn btn-danger">
                <i class="fa fa-fw fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.tambah-simpanan') }}" class="btn btn-info">
                <i class="fa fa-fw fa-plus"></i>
                Tambah Simpanan
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
                            @foreach ($anggota->simpanan as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $s->tgl_simpanan_dmy }}</td>
                                    <td>{{ $s->jenis_simpanan }}</td>
                                    <td>{{ $s->jumlah_simpanan }}</td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                            data-toggle="modal" data-target="#modalEditSimpanan{{ $s->id }}" />

                                        <x-adminlte-modal id="modalEditSimpanan{{ $s->id }}" title="Edit Data"
                                            theme="primary" icon="fas fa-fw fa-pen" size="md" class="text-left">
                                            <form action="{{ route('put.edit-simpanan', ['id_simpanan' => $s->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <x-adminlte-input name="tgl_simpanan" label="Tanggal Simpanan"
                                                        type="date" placeholder="Tanggal Simmpanan"
                                                        value="{{ $s->tgl_simpanan }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-select name="jenis_simpanan" label="Jenis Simpanan">
                                                        <option value="" selected disabled>Jenis Simpanan</option>
                                                        <option value="pokok"
                                                            {{ $s->jenis_simpanan == 'pokok' ? 'selected' : '' }}>
                                                            Pokok
                                                        </option>
                                                        <option value="wajib"
                                                            {{ $s->jenis_simpanan == 'wajib' ? 'selected' : '' }}>
                                                            Wajib
                                                        </option>
                                                        <option value="sukarela"
                                                            {{ $s->jenis_simpanan == 'sukarela' ? 'selected' : '' }}>
                                                            Sukarela
                                                        </option>
                                                    </x-adminlte-select>
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jumlah_simpanan" label="Jumlah Simpanan"
                                                        type="number" placeholder="Jumlah Simpanan"
                                                        value="{{ old('jumlah_simpanan') }}" />
                                                </div>

                                                <div class="text-right">
                                                    <x-adminlte-button type="button" theme="outline-primary"
                                                        label="Batal Edit" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="primary"
                                                        icon="fas fa-fw fa-pen" label="Edit" />
                                                </div>
                                            </form>

                                            <x-slot name="footerSlot"></x-slot>
                                        </x-adminlte-modal>

                                        {{-- Hapus --}}
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapusSimpanan{{ $s->id }}" />

                                        <x-adminlte-modal id="modalHapusSimpanan{{ $s->id }}" title="Hapus Data"
                                            theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <x-slot name="footerSlot">
                                                <form
                                                    action="{{ route('delete.hapus-simpanan', ['id_simpanan' => $s->id]) }}"
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
