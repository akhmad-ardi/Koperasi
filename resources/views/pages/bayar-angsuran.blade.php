@extends('adminlte::page')

@section('title', 'Bayar Angsuran')

@section('content_header')
    <h1>Bayar Angsuran</h1>
@stop

@section('content')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('post.bayar-angsuran', ['id_anggota' => $anggota->id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <x-adminlte-input name="pinjaman" id="pinjaman" label="Pinjaman Saat Ini" type="text"
                                placeholder="Pinjaman Saat Ini" value="{{ $total_pinjaman }}" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="tgl_angsuran" label="Tanggal Angsuran" type="date"
                                placeholder="Tanggal Angsuran" value="{{ old('tgl_angsuran') ?? date('Y-m-d') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jumlah_angsuran" id="jumlah_angsuran" label="Jumlah Angsuran"
                                type="number" placeholder="Jumlah Angsuran" value="{{ old('jumlah_angsuran') }}" />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="jasa" id="jasa" label="Jasa" type="text" placeholder="Jasa"
                                value="{{ old('jasa') }}" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-input name="total_angsuran" id="total_angsuran" label="Total Angsuran"
                                type="text" placeholder="Total Angsuran" value="{{ old('total_angsuran') }}" disabled />
                        </div>

                        <div class="mb-3">
                            <x-adminlte-select name="status" label="Status">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="lunas" {{ old('status') == 'lunas' ? 'selected' : '' }}>
                                    Lunas
                                </option>
                                <option value="belum lunas" {{ old('status') == 'belum lunas' ? 'selected' : '' }}>
                                    Belum Lunas
                                </option>
                            </x-adminlte-select>
                        </div>

                        <div class="mb-3 text-right">
                            <a href="{{ route('admin.detail-pinjaman', ['id_anggota' => $anggota->id]) }}"
                                class="btn btn-outline-primary">Kembali</a>

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
        const pinjamanInput = document.getElementById('pinjaman');
        const jumlahAngsuranInput = document.getElementById('jumlah_angsuran');
        const jasaInput = document.getElementById('jasa');
        const totalAngsuranInput = document.getElementById('total_angsuran');

        function rupiahToNumber(rupiah) {
            return parseFloat(rupiah.replace(/[^0-9]/g, '')) || 0;
        }

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        jumlahAngsuranInput.addEventListener('input', function() {
            let pinjaman = rupiahToNumber(pinjamanInput.value);
            let jumlahAngsuran = parseFloat(jumlahAngsuranInput.value) || 0;

            // hitung jasa 3% dari pinjaman
            let jasa = pinjaman * 0.03;

            jasaInput.value = formatRupiah(Math.round(jasa));

            totalAngsuranInput.value = formatRupiah(Math.round(jumlahAngsuran + jasa));
        });
    </script>
@stop
