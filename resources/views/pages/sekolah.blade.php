@extends('adminlte::page')

@section('title', 'Sekolah')

@section('content_header')
    <h1>Data Sekolah</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col-md-2">
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('admin.tambah-sekolah') }}" class="btn btn-primary">
                    <i class="fas fa-fw fa-plus"></i>
                    Tambah Anggota
                </a>
            @endif
        </div>
        <div class="col-md-5">
            <form method="GET" action="{{ route('admin.sekolah') }}">
                <x-adminlte-input name="nama" placeholder="Cari nama sekolah..." igroup-size="md"
                    value="{{ request('nama') }}">
                    <x-slot name="appendSlot">
                        <x-adminlte-button type="submit" theme="outline-primary" icon="fa fa-fw fa-search" />
                    </x-slot>
                </x-adminlte-input>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Nama Sekolah</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sekolah as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $s->nama_sekolah }}</td>
                                    <td>{{ $s->alamat }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role == 'admin')
                                            {{-- Edit --}}
                                            <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                                data-toggle="modal" data-target="#modalEdit{{ $s->id }}" />

                                            <x-adminlte-modal id="modalEdit{{ $s->id }}" title="Edit Data"
                                                theme="primary" icon="fas fa-fw fa-pen" size='md'>
                                                <form action="{{ route('put.edit-sekolah', ['id' => $s->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3 text-left">
                                                        <x-adminlte-input name="nama_sekolah" label="Nama Sekolah"
                                                            placeholder="Nama Sekolah"
                                                            value="{{ old('nama_sekolah') ?: $s->nama_sekolah }}" />
                                                    </div>
                                                    <div class="mb-3 text-left">
                                                        <x-adminlte-input name="alamat" label="Alamat Sekolah"
                                                            placeholder="Alamat Sekolah"
                                                            value="{{ old('alamat') ?: $s->alamat }}" />
                                                    </div>

                                                    <div class="text-right">
                                                        <x-adminlte-button type="button" theme="outline-primary"
                                                            label="Batal Edit" data-dismiss="modal" />
                                                        <x-adminlte-button type="submit" theme="primary"
                                                            icon="fas fa-fw fa-pen" label="Simpan Edit" />
                                                    </div>
                                                    <x-slot name="footerSlot">

                                                    </x-slot>
                                                </form>
                                            </x-adminlte-modal>

                                            <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                                data-toggle="modal" data-target="#modalHapus{{ $s->id }}" />

                                            <x-adminlte-modal id="modalHapus{{ $s->id }}" title="Hapus Data"
                                                theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                                <p>Apakah anda ingin menghapus data ini ?</p>
                                                <x-slot name="footerSlot">
                                                    <form action="{{ route('delete.hapus-sekolah', ['id' => $s->id]) }}"
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
                                        @else
                                            {{-- Jika ketua: tampilkan ikon larangan --}}
                                            <i class="fas fa-ban fa-2x text-danger" title="Tidak memiliki akses"></i>
                                        @endif
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
    @if (session('modal_id'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#modalEdit{{ session('modal_id') }}').modal('show');
            });
        </script>
    @endif

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
