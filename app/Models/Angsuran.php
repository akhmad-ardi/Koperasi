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
        'angsuran_ke',
        'tgl_angsuran',
        'jumlah_angsuran',
        'jasa',
        'total_angsuran',
        'status'
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }
}
