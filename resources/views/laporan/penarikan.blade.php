<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penarikan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .kop-surat .logo {
            position: absolute;
            left: 0;
        }

        .kop-surat img {
            width: 50px;
            height: 50px;
        }

        .kop-text {
            margin: 0 auto;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        hr {
            border: 1px solid #000;
            margin-top: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
            white-space: nowrap;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }

        td {
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <div class="logo">
            <img src="{{ public_path('logo-koperasi.png') }}" alt="Logo Koperasi">
        </div>
        <div class="kop-text">
            <h1>KOPERASI SIMPAN PINJAM MAKMUR</h1>
            <p>Jl. Merdeka No. 123, Jakarta</p>
            <p>Telp: (021) 123456 | Email: info@koperasi.com</p>
        </div>
    </div>
    <hr>

    <!-- Judul Laporan -->
    <h2 style="text-align:center;">Laporan Penarikan Anggota</h2>

    <!-- Tabel Data -->
    <table>
        <thead>
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
                    <td colspan="7" style="text-align:center;">Tidak ada data penarikan</td>
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
</body>

</html>
