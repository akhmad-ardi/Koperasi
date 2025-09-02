<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Angsuran extends Model
{
    use HasFactory;

    protected $table = 'angsuran';
    protected $primaryKey = 'id';
    public $timestamps = false; // karena tabel ini tidak punya created_at/updated_at
    protected $fillable = [
        'id_pinjaman',
        'tgl_angsuran',
        'jumlah_angsuran',
        'jasa',
        'total_angsuran',
    ];

    protected static function booted()
    {
        static::creating(function ($angsuran) {
            // Ambil nomor angsuran terakhir untuk anggota ini
            $lastNumber = self::where('id_pinjaman', $angsuran->id_pinjaman)
                ->max('angsuran_ke');

            // Kalau belum ada, mulai dari 1
            $angsuran->angsuran_ke = $lastNumber ? $lastNumber + 1 : 1;

            // Hitung total angsuran
            $angsuran->total_angsuran = $angsuran->jumlah_angsuran + ($angsuran->jasa ?? 0);
        });
    }

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }
}
