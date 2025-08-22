@extends('adminlte::page')

@section('title', 'Laporan Penarikan')

@section('content_header')
    <h1>Laporan Penarikan</h1>
@stop

@section('content')
    <form method="GET" action="{{ route('admin.laporan.penarikan') }}" class="mb-3">
        <div class="row align-items-center">
            {{-- Input filter tanggal mulai --}}
            <div class="col-auto d-flex align-items-center">
                <label for="start_date" class="fw-bold mb-0" style="margin-right: 8px;">Dari</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $start_date }}"
                    style="max-width: 200px;">
            </div>

            {{-- Input filter tanggal akhir --}}
            <div class="col-auto d-flex align-items-center">
                <label for="end_date" class="fw-bold mb-0" style="margin-right: 8px;">Sampai</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $end_date }}"
                    style="max-width: 200px;">
            </div>

            {{-- Tombol filter & reset --}}
            <div class="col-auto">
                <button type="submit" class="btn btn-success" style="margin-right: 12px;">
                    Filter
                </button>

                <a href="{{ route('admin.laporan.simpanan') }}" class="btn btn-secondary" style="margin-right: 12px;">
                    Reset
                </a>
            </div>

            {{-- Tombol unduh laporan --}}
            <div class="col text-end pe-5">
                <a href="{{ route('laporan.penarikan.pdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                    class="btn btn-primary" target="_blank">
                    <i class="fa fa-fw fa-download"></i> Unduh Laporan
                </a>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>No. Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Sekolah</th>
                        <th>Tanggal Penarikan</th>
                        <th>Jenis Simpanan</th>
                        <th>Jumlah Penarikan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penarikan as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $p->anggota->no_anggota ?? '-' }}</td>
                            <td>{{ $p->anggota->nama ?? '-' }}</td>
                            <td>{{ $p->anggota->sekolah->nama_sekolah ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tgl_penarikan)->format('d-m-Y') }}</td>
                            <td>{{ ucfirst($p->jenis_simpanan) }}</td>
                            <td class="text-end">Rp {{ number_format($p->jumlah_penarikan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data penarikan</td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($penarikan->count() > 0)
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Total Penarikan</th>
                            <th class="text-end">
                                Rp {{ number_format($penarikan->sum('jumlah_penarikan'), 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@stop


@section('css')
    <style>
        table th {
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
        }

        table td {
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Laporan Penarikan Loaded');
    </script>
@stop
