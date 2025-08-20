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
            /* biar tidak turun baris */
        }

        th {
            background: #f2f2f2;
            text-align: center;
            /* judul kolom rata tengah */
        }

        td {
            text-align: left;
            /* isi data rata kiri */
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Penarikan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Anggota</th>
                <th>Nama Anggota</th>
                <th>Sekolah</th>
                <th>Total Penarikan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $a->no_anggota }}</td>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->sekolah->nama_sekolah ?? '-' }}</td>
                    <td>Rp {{ number_format($a->total_penarikan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
