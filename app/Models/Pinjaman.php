<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'status',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }
}
