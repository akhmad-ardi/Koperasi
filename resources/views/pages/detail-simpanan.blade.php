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
                            value="{{ $simpanan[0]->anggota->no_anggota }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                            value="{{ $simpanan[0]->anggota->nama }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="total_simpanan_pokok" label="Total Simpanan Pokok" type="text"
                            placeholder="Total Simpanan Pokok" value="{{ $total_simpanan_pokok }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="total_simpanan_wajib" label="Total Simpanan Wajib" type="text"
                            placeholder="Total Simpanan Wajib" value="{{ $total_simpanan_wajib }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="total_simpanan_sukarela" label="Total Simpanan Sukarela" type="text"
                            placeholder="Total Simpanan Sukarela" value="{{ $total_simpanan_sukarela }}" disabled />
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
            <a href="{{ route('admin.tambah-simpanan') }}" class="btn btn-primary">
                <i class="fa fa-fw fa-plus"></i>
                Tambah Simpanan
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($simpanan as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $s->tgl_simpanan }}</td>
                                    <td>{{ $s->jenis_simpanan }}</td>
                                    <td>{{ $s->jumlah_simpanan }}</td>
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
