@extends('adminlte::page')

@section('title', 'Laporan Simpanan')

@section('content_header')
    <h1>Laporan Simpanan</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('laporan.simpanan.pdf') }}" class="btn btn-primary">
                <i class="fa fa-fw fa-download"></i>
                Unduh Laporan
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
                                <th class="text-center">Sekolah</th>
                                <th class="text-center">Total Simpanan</th>
                                <th class="text-center">Total Penarikan</th>
                                <th class="text-center">Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->no_anggota }}</td>
                                    <td>{{ $a->nama }}</td>
                                    <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                                    <td>{{ $a->jumlah_simpanan }}</td>
                                    <td>{{ $a->jumlah_penarikan }}</td>
                                    <td>{{ $a->saldo }}</td>
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
@section('css')
    <style>
        /* Header tabel */
        #anggotaTable th {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Isi tabel */
        #anggotaTable td {
            text-align: left;
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
@stop

@stop

@section('js')
<script>
    console.log('Dashboard Loaded');
</script>
@stop
