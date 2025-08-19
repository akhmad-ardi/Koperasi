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
                            value="{{ $anggota->no_anggota }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="nama" label="Nama" type="text" placeholder="Nama"
                            value="{{ $anggota->nama }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="jumlah_pinjaman" label="Jumlah Pinjaman" type="text"
                            placeholder="Jumlah Pinjaman" value="{{ $total_pinjaman }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.pinjaman') }}" class="btn btn-danger">
                <i class="fa fa-fw fa-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.bayar-angsuran', ['id_anggota' => $anggota->id]) }}" class="btn btn-info">
                <i class="fa fa-fw fa-hand-holding-usd"></i>
                Bayar Angsuran
            </a>
            <a href="{{ route('admin.tambah-pinjaman') }}" class="btn btn-primary">
                <i class="fa fa-fw fa-hand-holding-usd"></i>
                Tambah Pinjaman
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3 class="text-center">Pinjaman</h3>

            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Tanggal Pinjaman</th>
                                <th class="text-center">Jumlah Pinjaman</th>
                                <th class="text-center">Jaminan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->pinjaman as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->tgl_pinjaman }}</td>
                                    <td>{{ $p->jumlah_pinjaman }}</td>
                                    <td>{{ $p->jaminan }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td class="text-center">
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapus{{ $p->id }}" />

                                        <x-adminlte-modal id="modalHapus{{ $p->id }}" title="Hapus Data"
                                            theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <x-slot name="footerSlot">
                                                <form
                                                    action="{{ route('delete.hapus-pinjaman', ['id_pinjaman' => $p->id]) }}"
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

    <div class="row">
        <div class="col">
            <h3 class="text-center">Angsuran</h3>
            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Angsuran Ke</th>
                                <th class="text-center">Tanggal Angsuran</th>
                                <th class="text-center">Jumlah Angsuran</th>
                                <th class="text-center">Jasa</th>
                                <th class="text-center">Total Angsuran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->angsuran as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->angsuran_ke }}</td>
                                    <td>{{ $a->tgl_angsuran }}</td>
                                    <td>{{ $a->jumlah_angsuran }}</td>
                                    <td>{{ $a->jasa }}</td>
                                    <td>{{ $a->total_angsuran }}</td>
                                    <td>{{ $a->status }}</td>
                                    <td class="text-center">
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapus{{ $a->id }}" />

                                        <x-adminlte-modal id="modalHapus{{ $a->id }}" title="Hapus Data"
                                            theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                            <p>Apakah anda ingin menghapus data ini ?</p>
                                            <x-slot name="footerSlot">
                                                <form
                                                    action="{{ route('delete.hapus-angsuran', ['id_angsuran' => $a->id]) }}"
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
