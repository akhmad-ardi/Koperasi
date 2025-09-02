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
                        <x-adminlte-input name="sekolah" label="Sekolah" type="text" placeholder="Sekolah"
                            value="{{ $anggota->sekolah->nama_sekolah ?? '-' }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="status" label="Status Pinjaman" type="text" class="text-capitalize"
                            placeholder="Status Pinjaman" value="{{ $total_pinjaman == 'Rp 0' ? 'lunas' : 'belum lunas' }}"
                            disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="total_pinjaman" label="Total Pinjaman" type="text"
                            placeholder="Total Pinjaman" value="{{ $total_pinjaman }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col">
            <a href="{{ route('admin.pinjaman') }}" class="btn btn-danger">
                <i class="fa fa-fw fa-arrow-left"></i>
                Kembali
            </a>
            @if (Auth::user()->role == 'admin')
                <a href="{{ route('admin.tambah-pinjaman') }}" class="btn btn-primary">
                    <i class="fa fa-fw fa-hand-holding-usd"></i>
                    Tambah Pinjaman
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3 class="text-center">Pinjaman</h3>

            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Tanggal Pinjaman</th>
                                <th class="text-center">Jatuh Tempo</th>
                                <th class="text-center">Jaminan</th>
                                <th class="text-center">Jumlah Pinjaman</th>
                                <th class="text-center">Denda</th> {{-- Tambahan --}}
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->pinjaman as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $p->tgl_pinjaman }}</td>
                                    <td class="text-center">{{ $p->jatuh_tempo }}</td>
                                    <td>{{ $p->jaminan }}</td>
                                    <td>{{ $p->tunggakan_rupiah }}</td>
                                    <td>
                                        @if ($p->denda > 0)
                                            <span class="badge badge-danger">
                                                Rp {{ number_format($p->denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.detail-pinjaman', ['id_pinjaman' => $p->id]) }}"
                                            class="btn btn-info">
                                            <i class="fas fa-fw fa-hand-holding-usd"></i>
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.edit-pinjaman', ['id_pinjaman' => $p->id]) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-fw fa-pen"></i>
                                            Edit
                                        </a>

                                        {{-- Hapus --}}
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapusPinjaman{{ $p->id }}" />

                                        <x-adminlte-modal id="modalHapusPinjaman{{ $p->id }}"
                                            title="Hapus Data Pinjaman" theme="danger" icon="fas fa-fw fa-trash"
                                            size='md'>
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
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">Jumlah</th>
                                <th>
                                    {{ $total_pinjaman }}
                                </th>
                                <th class="text-center">
                                    Rp {{ number_format($anggota->pinjaman->sum('denda'), 0, ',', '.') }}
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
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
    <script>
        function rupiahToNumber(rupiah) {
            return parseFloat(rupiah.replace(/[^0-9]/g, '')) || 0;
        }

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ambil semua input jumlah angsuran
            const jumlahAngsuranInputs = document.querySelectorAll('[id^="jumlah_angsuran_"]');

            jumlahAngsuranInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    // contoh id: jumlah_angsuran_12_0 → ['jumlah','angsuran','12','0']
                    const parts = this.id.split('_');
                    const anggotaId = parts[2]; // $a->id
                    const index = parts[3]; // $loop->index

                    // ambil elemen terkait
                    const pinjamanInput = document.getElementById('pinjaman_' +
                        anggotaId + "_" + index); // kalau pinjaman juga per anggota
                    const jasaInput = document.getElementById('jasa_' + anggotaId + '_' + index);
                    const totalAngsuranInput = document.getElementById('total_angsuran_' +
                        anggotaId + '_' + index);

                    let pinjaman = rupiahToNumber(pinjamanInput.value);
                    let jumlahAngsuran = parseFloat(this.value) || 0;

                    // hitung jasa 3% dari pinjaman
                    let jasa = pinjaman * 0.03;
                    jasaInput.value = formatRupiah(Math.round(jasa));

                    // total angsuran
                    totalAngsuranInput.value = formatRupiah(Math.round(jumlahAngsuran + jasa));
                });
            });
        });
    </script>



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
