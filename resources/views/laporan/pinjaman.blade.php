<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pinjaman</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
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
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center">Laporan Pinjaman Anggota</h2>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nomor Anggota</th>
                <th>Nama Anggota</th>
                <th>Total Pinjaman</th>
                <th>Total Angsuran Pokok</th>
                <th>Total Jasa</th>
                <th>Total Angsuran</th>
                <th>Sisa Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->no_anggota }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>Rp {{ number_format($a->total_pinjaman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->angsuran->sum('jumlah_angsuran'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->angsuran->sum('jasa'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->total_angsuran, 0, ',', '.') }}</td>                        <td>Rp {{ number_format($a->sisa_pinjaman, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
