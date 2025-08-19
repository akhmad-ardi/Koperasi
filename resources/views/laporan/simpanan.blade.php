<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Simpanan</title>
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
    <h2 style="text-align:center;">Laporan Simpanan Anggota</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>Nama</th>
                <th>Total Simpanan</th>
                <th>Total Penarikan</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->no_anggota }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>Rp {{ number_format($a->simpanan->sum('jumlah_simpanan'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->penarikan->sum('jumlah_penarikan'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->saldo, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
