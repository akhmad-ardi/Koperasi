<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penarikan extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'penarikan';

    // Primary key
    protected $primaryKey = 'id';

    // Tidak menggunakan timestamps
    public $timestamps = false;

    // Kolom yang bisa diisi
    protected $fillable = [
        'id_anggota',
        'tgl_penarikan',
        'jenis_simpanan',
        'jumlah_penarikan',
        'keterangan',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
