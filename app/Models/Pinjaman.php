<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pinjaman extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'pinjaman';

    // Primary key
    protected $primaryKey = 'id';

    // Tidak menggunakan timestamps (created_at & updated_at)
    public $timestamps = false;

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'id_anggota',
        'tgl_pinjaman',
        'jumlah_pinjaman',
        'jaminan',
        'tenor',
        'jatuh_tempo',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'id_pinjaman', 'id');
    }

    public function getTunggakanAttribute()
    {
        $tunggakan = (int) $this->jumlah_pinjaman - (int) $this->angsuran->sum('jumlah_angsuran');
        return max($tunggakan, 0); // minimal 0, biar tidak negatif
    }

    public function getDendaAttribute()
    {
        $jatuhTempo = Carbon::parse($this->jatuh_tempo);

        if ($this->tunggakan > 0 && now()->gt($jatuhTempo)) {
            return $this->tunggakan * 0.03; // 3% dari tunggakan
        }

        return 0;
    }
}
