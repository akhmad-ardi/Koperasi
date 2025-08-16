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
                                    <td>{{ $p->jenis_simpanan }}</td>
                                    <td>{{ $p->jumlah_penarikan }}</td>
                                    <td>{{ $p->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('admin.detail-penarikan', ['id_anggota' => $p->anggota->id]) }}"
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
