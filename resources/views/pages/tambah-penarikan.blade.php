@extends('adminlte::page')

@section('title', 'Tambah Penarikan')

@section('content_header')
    <h1>Tambah Data Penarikan</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.tambah-penarikan') }}" method="POSt">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <x-adminlte-select id="id_anggota" name="id_anggota" label="Nomor Anggota">
                                <option value="" selected disabled>Pilih Anggota</option>
                                @foreach ($anggota as $a)
                                    <option value="{{ $a->id }}" data-nama="{{ $a->nama }}"
                                        data-simpanan='@json($a->simpanan->groupBy('jenis_simpanan')->map->sum('jumlah_simpanan'))'
                                        data-penarikan='@json($a->penarikan->groupBy('jenis_simpanan')->map->sum('jumlah_penarikan'))'>
                                        {{ $a->no_anggota }} | {{ $a->nama }}
                                    </option>
                                @endforeach
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input id="nama" name="nama" label="Nama Anggota" type="text"
                                placeholder="Nama Anggota" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tgl_penarikan" label="Tanggal Penarikan" type="date"
                                value="{{ old('tgl_penarikan') ?? date('Y-m-d') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-select id="jenis_simpanan" name="jenis_simpanan" label="Jenis Simpanan">
                                <option value="" selected disabled>Jenis Simpanan</option>
                                <option value="pokok" {{ old('jenis_simpanan') == 'pokok' ? 'selected' : '' }}>Pokok
                                </option>
                                <option value="wajib" {{ old('jenis_simpanan') == 'wajib' ? 'selected' : '' }}>Wajib
                                </option>
                                <option value="sukarela" {{ old('jenis_simpanan') == 'sukarela' ? 'selected' : '' }}>
                                    Sukarela</option>
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input id="jumlah_simpanan" name="jumlah_simpanan" label="Jumlah Simpanan"
                                type="text" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_penarikan" label="Jumlah Penarikan" type="number"
                                placeholder="Jumlah Penarikan" value="{{ old('jumlah_penarikan') }}" />
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.penarikan') }}" class="btn btn-outline-primary">Kembali</a>

                            <x-adminlte-button type="submit" theme="primary" label="Simpan" />
                        </div>
                    </form>
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
            const anggotaSelect = document.getElementById("id_anggota");
            const jenisSelect = document.getElementById("jenis_simpanan");
            const namaInput = document.getElementById("nama");
            const simpananInput = document.getElementById("jumlah_simpanan");

            let simpananData = {};
            let penarikanData = {};

            anggotaSelect.addEventListener("change", function() {
                const selected = this.options[this.selectedIndex];
                namaInput.value = selected.dataset.nama;

                // simpan data simpanan & penarikan ke variabel
                simpananData = JSON.parse(selected.dataset.simpanan || "{}");
                penarikanData = JSON.parse(selected.dataset.penarikan || "{}");

                simpananInput.value = ""; // reset
            });

            jenisSelect.addEventListener("change", function() {
                const jenis = this.value;

                let totalSimpanan = simpananData[jenis] ?? 0;
                let totalPenarikan = penarikanData[jenis] ?? 0;

                let saldo = totalSimpanan - totalPenarikan;

                simpananInput.value = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0
                }).format(saldo);;
            });
        });
    </script>

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
