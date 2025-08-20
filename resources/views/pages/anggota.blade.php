@extends('adminlte::page')

@section('title', 'Anggota')

@section('content_header')
    <h1>Data Anggota</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col-md-2">
            <a href="{{ route('admin.tambah-anggota') }}" class="btn btn-primary">
                <i class="fas fa-fw fa-plus"></i>
                Tambah Anggota
            </a>
        </div>
        <div class="col-md-5">
            <form method="GET" action="{{ route('admin.anggota') }}">
                <x-adminlte-input name="nama" placeholder="Cari nama angggota..." igroup-size="md"
                    value="{{ request('nama') }}">
                    <x-slot name="appendSlot">
                        <x-adminlte-button type="submit" theme="outline-primary" label="Search" />
                    </x-slot>
                </x-adminlte-input>
            </form>
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
                                <th class="text-center">Tanggal Lahir</th>
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
                                    <td class="text-center d-flex">
                                        {{-- Detail --}}
                                        <a href="{{ route('admin.detail-anggota', ['id_anggota' => $a->id]) }}"
                                            class="btn btn-info mr-1">
                                            <i class="fa fa-fw fa-user"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.edit-anggota', ['id_anggota' => $a->id]) }}"
                                            class="btn btn-primary mr-1">
                                            <i class="fa fa-fw fa-pen"></i>
                                        </a>

                                        {{-- Hapus --}}
                                        <x-adminlte-button label="" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapus" />

                                        <x-adminlte-modal id="modalHapus" title="Hapus Data" theme="danger"
                                            icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <x-slot name="footerSlot">
                                                <form
                                                    action="{{ route('delete.hapus-anggota', ['id_anggota' => $a->id]) }}"
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

    @if (session('msg_error'))
        <script>
            toastr.error("{{ session('msg_error') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif
@stop
