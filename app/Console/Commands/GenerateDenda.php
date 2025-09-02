<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pinjaman;
use App\Models\Denda;
use Carbon\Carbon;

class GenerateDenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'denda:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate denda otomatis untuk pinjaman yang jatuh tempo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();

        $today = now(); // pastikan ada definisi tanggal hari ini

        $pinjamanJatuhTempo = Pinjaman::where('jatuh_tempo', '<', $today)
            ->doesntHave('denda') // hanya pinjaman yang belum ada denda
            ->get();

        foreach ($pinjamanJatuhTempo as $pinjaman) {
            $jumlahDenda = $pinjaman->jumlah_pinjaman * 0.01; // 1% dari jumlah pinjaman

            Denda::create([
                'id_pinjaman' => $pinjaman->id,
                'tgl_denda' => $today,
                'jumlah_denda' => $jumlahDenda,
                'status' => 'belum lunas' // pastikan default sesuai enum
            ]);
        }

        $this->info("Denda otomatis berhasil dibuat untuk pinjaman jatuh tempo.");
    }
}
