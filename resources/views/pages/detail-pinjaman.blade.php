@extends('adminlte::page')

@section('title', 'Informasi Pinjaman')

@section('content_header')
    <h1>Informasi Pinjaman</h1>
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
                            value="{{ $detail_pinjaman->anggota->no_anggota }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                            value="{{ $detail_pinjaman->anggota->nama }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                            value="{{ $detail_pinjaman->jumlah_pinjaman }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.bayar-angsuran', ['id_pinjaman' => $detail_pinjaman->id]) }}" class="btn btn-primary">
                <i class="fa fa-fw fa-hand-holding-usd"></i>
                Bayar Angsuran
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
                                <th class="text-center">Angsuran Ke</th>
                                <th class="text-center">No. Anggota</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Angsuran</th>
                                <th class="text-center">Jumlah Angsuran</th>
                                <th class="text-center">Jasa</th>
                                <th class="text-center">Total Angsuran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_pinjaman->angsuran as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->angsuran_ke }}</td>
                                    <td>{{ $a->pinjaman->anggota->no_anggota }}</td>
                                    <td>{{ $a->pinjaman->anggota->nama }}</td>
                                    <td>{{ $a->tgl_angsuran }}</td>
                                    <td>{{ $a->jumlah_angsuran }}</td>
                                    <td>{{ $a->jasa }}</td>
                                    <td>{{ $a->total_angsuran }}</td>
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
