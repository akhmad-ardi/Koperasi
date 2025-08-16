<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Simpanan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #eee;
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
            @foreach ($anggota as $i => $a)
                <tr>
                    <td>{{ $i + 1 }}</td>
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
