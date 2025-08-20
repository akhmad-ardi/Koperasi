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
        <div class="col-md-2">
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('admin.tambah-penarikan') }}" class="btn btn-primary">
                    <i class="fas fa-fw fa-plus"></i>
                    Tambah Data
                </a>
            @endif
        </div>
        <div class="col-md-5">
            <form method="GET" action="{{ route('admin.penarikan') }}">
                <x-adminlte-input name="nama" placeholder="Cari nama anggota..." igroup-size="md"
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
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">No. Anggota</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Total Penarikan Pokok</th>
                                <th class="text-center">Total Penarikan Wajib</th>
                                <th class="text-center">Total Penarikan Sukarela</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->total_penarikan_pokok }}</td>
                                    <td>{{ $a->total_penarikan_wajib }}</td>
                                    <td>{{ $a->total_penarikan_sukarela }}</td>
                                    <td>
                                        <a href="{{ route('admin.detail-penarikan', ['id_anggota' => $a->id]) }}"
                                            class="btn btn-info">
                                            <i class="fa fa-fw fa-hand-holding-usd"></i>
                                            Detail
                                        </a>
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
