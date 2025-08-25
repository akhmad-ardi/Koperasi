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

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
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
    <h2>Laporan Pinjaman Anggota</h2>
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
            @php
                $no = 1;
                $totalPokok = 0;
                $totalJasa = 0;
                $totalAngsuran = 0;
                $totalSisa = 0;
            @endphp
            @foreach ($anggota as $a)
                @php
                    $totalPinjaman = $a->pinjaman->sum('jumlah_pinjaman');
                @endphp
                @foreach ($a->angsuran as $angsuran)
                    @php
                        $totalPokok += $angsuran->jumlah_angsuran;
                        $totalJasa += $angsuran->jasa;
                        $totalAngsuran += $angsuran->jumlah_angsuran + $angsuran->jasa;
                        $totalSisa += $angsuran->sisa_pinjaman;
                        $status = $angsuran->sisa_pinjaman > 0 ? 'Belum Lunas' : 'Lunas';
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $a->no_anggota }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                        <td>Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($angsuran->tgl_angsuran)->format('d-m-Y') }}</td>
                        <td>Rp {{ number_format($angsuran->jumlah_angsuran, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($angsuran->jasa, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($angsuran->jumlah_angsuran + $angsuran->jasa, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($angsuran->sisa_pinjaman, 0, ',', '.') }}</td>
                        <td>
                            <span
                                style="background-color: {{ $status == 'Lunas' ? 'rgb(40,167,69)' : 'rgb(220,53,69)' }};
                                         color: rgb(255,255,255); padding: 3px 6px; border-radius: 4px;">
                                {{ $status }}
                            </span>
                        </td>


                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-align:center">TOTAL</th>
                <th>Rp {{ number_format($totalPokok, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($totalJasa, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($totalAngsuran, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($totalSisa, 0, ',', '.') }}</th>
                <th>-</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
