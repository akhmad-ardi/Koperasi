<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pinjaman</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Pinjaman Anggota</h2>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nama Anggota</th>
                <th>Total Pinjaman</th>
                <th>Total Angsuran</th>
                <th>Sisa Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $a)
                <tr>
                    <td>{{ $a->nama }}</td>
                    <td>Rp {{ number_format($a->total_pinjaman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->total_angsuran, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($a->sisa_pinjaman, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
