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

    public function denda()
    {
        return $this->hasMany(Denda::class, 'id_pinjaman');
    }

    public function getTunggakanAttribute()
    {
        $tunggakan = (int) $this->jumlah_pinjaman - (int) $this->angsuran->sum('jumlah_angsuran');
        return max($tunggakan, 0); // minimal 0, biar tidak negatif
    }
}
