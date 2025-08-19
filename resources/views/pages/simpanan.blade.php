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
                                <th class="text-center">Saldo Pokok</th>
                                <th class="text-center">Saldo Wajib</th>
                                <th class="text-center">Saldo Sukarela</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->saldo_pokok }}</td>
                                    <td>{{ $a->saldo_wajib }}</td>
                                    <td>{{ $a->saldo_sukarela }}</td>
                                    <td class="text-center">
                                        {{-- Detail --}}
                                        <a href="{{ route('admin.detail-simpanan', ['id_anggota' => $a->id]) }}"
                                            class="btn btn-info">
                                            <i class="fa fa-fw fa-wallet"></i>
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
