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
    <h2 style="text-align:center;">Laporan Simpanan Anggota</h2>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>No</th>
                <th>No. Anggota</th>
                <th>Nama Anggota</th>
                <th>Sekolah</th>
                <th>Tanggal Simpanan</th>
                <th>Jenis Simpanan</th>
                <th>Jumlah Simpanan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($simpanan as $s)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $s->anggota->no_anggota ?? '-' }}</td>
                    <td>{{ $s->anggota->nama ?? '-' }}</td>
                    <td>{{ $s->anggota->sekolah->nama_sekolah ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($s->tgl_simpanan)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($s->jenis_simpanan) }}</td>
                    <td class="text-end">Rp {{ number_format($s->jumlah_simpanan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data simpanan</td>
                </tr>
            @endforelse
        </tbody>

        @if ($simpanan->count() > 0)
            <tfoot>
                <tr>
                    <th colspan="6" class="text-end">Total Simpanan</th>
                    <th class="text-end">
                        Rp {{ number_format($simpanan->sum('jumlah_simpanan'), 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>
        @endif

    </table>

</body>

</html>
