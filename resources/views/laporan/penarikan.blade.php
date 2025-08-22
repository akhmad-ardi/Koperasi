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
    <h2 style="text-align:center;">Laporan Penarikan Anggota</h2>

    <table>
        <thead class="text-center">
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
