<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pinjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            /* Sejajarkan vertikal */
            justify-content: center;
            /* Sejajarkan ke tengah horizontal */
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .kop-surat .logo {
            position: absolute;
            /* Logo di kiri */
            left: 0;
        }

        .kop-surat img {
            width: 50px;
            height: 50px;
        }

        .kop-text {
            margin: 0 auto;
            /* Pastikan teks benar-benar di tengah */
        }

        .kop-text h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        th {
            background: #f2f2f2;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <div class="logo">
            <img src="{{ public_path('logo-koperasi.png') }}" alt="Logo">
        </div>
        <div class="kop-text">
            <h1>KOPERASI SIMPAN PINJAM MAKMUR</h1>
            <p>Jl. Merdeka No. 123, Jakarta</p>
            <p>Telp: (021) 123456 | Email: info@koperasi.com</p>
        </div>
    </div>
    <hr>

    <h2 style="text-align:center;">Laporan Pinjaman Anggota</h2>
    <p style="text-align:center;">
        Periode: {{ $startDate ?? '-' }} s/d {{ $endDate ?? '-' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Anggota</th>
                <th>Nama Anggota</th>
                <th>Sekolah</th>
                <th>Jumlah Pinjaman</th>
                <th>Tanggal Angsuran</th>
                <th>Angsuran Pokok</th>
                <th>Jasa</th>
                <th>Total Angsuran</th>
                <th>Sisa Pinjaman</th>
                <th>Status Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach ($anggota as $a)
                @foreach ($a->pinjaman as $p)
                    @php
                        $totalAngsuran = $p->angsuran->sum('total_angsuran');
                        $sisaPinjaman = $p->jumlah_pinjaman - $p->angsuran->sum('jumlah_angsuran');
                        $status = $sisaPinjaman <= 0 ? 'Lunas' : 'Belum Lunas';
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $a->no_anggota }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                        <td>{{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td>{{ $p->angsuran->last()->tgl_angsuran ?? '-' }}</td>
                        <td>{{ number_format($p->angsuran->sum('jumlah_angsuran'), 0, ',', '.') }}</td>
                        <td>{{ number_format($p->angsuran->sum('jasa'), 0, ',', '.') }}</td>
                        <td>{{ number_format($totalAngsuran, 0, ',', '.') }}</td>
                        <td>{{ number_format($sisaPinjaman, 0, ',', '.') }}</td>
                        <td>{{ $status }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
