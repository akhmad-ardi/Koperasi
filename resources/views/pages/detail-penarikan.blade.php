@extends('adminlte::page')

@section('title', 'Detail Penarikan')

@section('content_header')
    <h1>Data Penarikan</h1>
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
                        <x-adminlte-input name="penarikan_pokok" label="Total Penarikan Pokok" type="text"
                            placeholder="Total Penarikan Pokok" value="{{ $penarikan_pokok }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="penarikan_wajib" label="Total Penarikan Wajib" type="text"
                            placeholder="Total Penarikan Wajib" value="{{ $penarikan_wajib }}" disabled />
                    </div>

                    <div class="mb-3">
                        <x-adminlte-input name="penarikan_sukarela" label="Total Penarikan Sukarela" type="text"
                            placeholder="Total Penarikan Sukarela" value="{{ $penarikan_sukarela }}" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.penarikan') }}" class="btn btn-danger">
                <i class="fa fa-fw fa-arrow-left"></i>
                Kembali
            </a>
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('admin.tambah-penarikan') }}" class="btn btn-primary">
                    <i class="fa fa-fw fa-plus"></i>
                    Tambah Penarikan
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table id="anggotaTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Nomor</th>
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">Jenis Simpanan</th>
                                <th class="text-center">Jumlah Penarikan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota->penarikan as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->tgl_penarikan_dmy }}</td>
                                    <td>{{ $p->jenis_simpanan }}</td>
                                    <td>{{ $p->jumlah_penarikan_rupiah }}</td>
                                    <td class="text-center">
                                        {{-- Edit --}}
                                        @if (auth()->user()->role == 'admin')
                                            <x-adminlte-button label="Edit" theme="primary" icon="fas fa-fw fa-pen"
                                                data-toggle="modal" data-target="#modalEditPenarikan{{ $p->id }}" />

                                            <x-adminlte-modal id="modalEditPenarikan{{ $p->id }}" title="Edit Data"
                                                theme="primary" icon="fas fa-fw fa-pen" size="md" class="text-left">
                                                <form
                                                    action="{{ route('put.edit-penarikan', ['id_penarikan' => $p->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <x-adminlte-input name="tgl_penarikan" label="Tanggal Penarikan"
                                                            type="date" value="{{ $p->tgl_penarikan }}" />
                                                    </div>

                                                    <div class="mb-3">
                                                        <x-adminlte-select
                                                            id="jenis_simpanan_{{ $p->id }}_{{ $loop->index }}"
                                                            name="jenis_simpanan" label="Jenis Simpanan">
                                                            <option value="" selected disabled>Jenis Simpanan</option>
                                                            <option value="pokok"
                                                                {{ $p->jenis_simpanan == 'pokok' ? 'selected' : '' }}>Pokok
                                                            </option>
                                                            <option value="wajib"
                                                                {{ $p->jenis_simpanan == 'wajib' ? 'selected' : '' }}>Wajib
                                                            </option>
                                                            <option value="sukarela"
                                                                {{ $p->jenis_simpanan == 'sukarela' ? 'selected' : '' }}>
                                                                Sukarela</option>
                                                        </x-adminlte-select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <x-adminlte-input
                                                            id="jumlah_simpanan_{{ $p->id }}_{{ $loop->index }}"
                                                            name="jumlah_simpanan" label="Jumlah Simpanan" type="text"
                                                            disabled />
                                                    </div>

                                                    <div class="mb-3">
                                                        <x-adminlte-input name="jumlah_penarikan" label="Jumlah Penarikan"
                                                            type="number" placeholder="Jumlah Penarikan"
                                                            value="{{ $p->jumlah_penarikan }}" />
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
                                                data-toggle="modal" data-target="#modalHapus{{ $p->id }}" />

                                            <x-adminlte-modal id="modalHapus{{ $p->id }}" title="Hapus Data"
                                                theme="danger" icon="fas fa-fw fa-trash" size='md'>
                                                <p>Apakah anda ingin menghapus data ini ?</p>
                                                <x-slot name="footerSlot">
                                                    <form
                                                        action="{{ route('delete.hapus-penarikan', ['id_penarikan' => $p->id]) }}"
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
                                        @else
                                            <i class="fas fa-ban fa-2x text-danger" title="Tidak memiliki akses"></i>
                                        @endif
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
        document.addEventListener("DOMContentLoaded", function() {
            const totalSimpanan = {
                pokok: {{ $total_simpanan_pokok }},
                wajib: {{ $total_simpanan_wajib }},
                sukarela: {{ $total_simpanan_sukarela }},
            };

            function formatRupiah(angka) {
                return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // cari semua select dengan id mulai dari "jenis_simpanan_"
            const allSelectJenis = document.querySelectorAll('[id^="jenis_simpanan_"]');

            allSelectJenis.forEach(select => {
                const uniqueId = select.id.replace("jenis_simpanan_", "");
                const jumlahInput = document.getElementById("jumlah_simpanan_" + uniqueId);

                function updateJumlah() {
                    const jenis = select.value;
                    const jumlah = totalSimpanan[jenis] || 0;
                    jumlahInput.value = formatRupiah(jumlah);
                }

                // event pas ganti
                select.addEventListener("change", updateJumlah);

                // isi default saat halaman load (kalau ada value terpilih)
                if (select.value) {
                    updateJumlah();
                }
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
