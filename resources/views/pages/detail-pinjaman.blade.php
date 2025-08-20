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
                                <th class="text-center">Jaminan</th>
                                <th class="text-center">Jumlah Pinjaman</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->pinjaman as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->tgl_pinjaman_dmy }}</td>
                                    <td>{{ $p->jaminan }}</td>
                                    <td>{{ $p->jumlah_pinjaman_rupiah }}</td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                            data-toggle="modal" data-target="#modalEditPinjaman{{ $p->id }}" />

                                        <x-adminlte-modal id="modalEditPinjaman{{ $p->id }}" title="Edit Data"
                                            theme="primary" icon="fas fa-fw fa-pen" size="md" class="text-left">
                                            <form action="{{ route('put.edit-pinjaman', ['id_pinjaman' => $p->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <x-adminlte-input name="tgl_pinjaman" label="Tanggal Pinjaman"
                                                        type="date" placeholder="Tanggal Pinjaman"
                                                        value="{{ $p->tgl_pinjaman }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jaminan" label="Jaminan" type="text"
                                                        placeholder="Jaminan" value="{{ $p->jaminan }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jumlah_pinjaman" label="Jumlah Pinjaman"
                                                        type="number" placeholder="Jumlah Pinjaman"
                                                        value="{{ $p->jumlah_pinjaman }}" />
                                                </div>

                                                <div class="text-right">
                                                    <x-adminlte-button type="button" theme="outline-primary"
                                                        label="Batal Edit" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="primary"
                                                        icon="fas fa-fw fa-pen" label="Edit" />
                                                </div>
                                            </form>

                                            <x-slot name="footerSlot"></x-slot>
                                        </x-adminlte-modal>

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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->angsuran as $a)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $a->angsuran_ke }}</td>
                                    <td>{{ $a->tgl_angsuran_dmy }}</td>
                                    <td>{{ $a->jumlah_angsuran_rupiah }}</td>
                                    <td>{{ $a->jasa_rupiah }}</td>
                                    <td>{{ $a->total_angsuran_rupiah }}</td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                            data-toggle="modal" data-target="#modalEditAngsuran{{ $a->id }}" />

                                        <x-adminlte-modal id="modalEditAngsuran{{ $a->id }}" title="Edit Data"
                                            theme="primary" icon="fas fa-fw fa-pen" size="md" class="text-left">
                                            <form action="{{ route('put.edit-angsuran', ['id_angsuran' => $a->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <x-adminlte-input name="pinjaman"
                                                        id="pinjaman_{{ $a->id }}_{{ $loop->index }}"
                                                        label="Pinjaman Saat Ini" type="text"
                                                        placeholder="Pinjaman Saat Ini" value="{{ $total_pinjaman }}"
                                                        disabled />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="tgl_angsuran" label="Tanggal Angsuran"
                                                        type="date" placeholder="Tanggal Angsuran"
                                                        value="{{ $a->tgl_angsuran }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jumlah_angsuran"
                                                        id="jumlah_angsuran_{{ $a->id }}_{{ $loop->index }}"
                                                        label="Jumlah Angsuran" type="number"
                                                        placeholder="Jumlah Angsuran"
                                                        value="{{ $a->jumlah_angsuran }}" />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="jasa"
                                                        id="jasa_{{ $a->id }}_{{ $loop->index }}" label="Jasa"
                                                        type="text" placeholder="Jasa" value="{{ $a->jasa_rupiah }}"
                                                        disabled />
                                                </div>

                                                <div class="mb-3">
                                                    <x-adminlte-input name="total_angsuran"
                                                        id="total_angsuran_{{ $a->id }}_{{ $loop->index }}"
                                                        label="Total Angsuran" type="text"
                                                        placeholder="Total Angsuran"
                                                        value="{{ $a->total_angsuran_rupiah }}" disabled />
                                                </div>

                                                <div class="text-right">
                                                    <x-adminlte-button type="button" theme="outline-primary"
                                                        label="Batal Edit" data-dismiss="modal" />
                                                    <x-adminlte-button type="submit" theme="primary"
                                                        icon="fas fa-fw fa-pen" label="Edit" />
                                                </div>
                                            </form>

                                            <x-slot name="footerSlot"></x-slot>
                                        </x-adminlte-modal>

                                        {{-- Hapus --}}
                                        <x-adminlte-button label="Hapus" theme="danger" icon="fas fa-fw fa-trash"
                                            data-toggle="modal" data-target="#modalHapusAngsuran{{ $a->id }}" />

                                        <x-adminlte-modal id="modalHapusAngsuran{{ $a->id }}"
                                            title="Hapus Data Angsuran" theme="danger" icon="fas fa-fw fa-trash"
                                            size='md'>
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
