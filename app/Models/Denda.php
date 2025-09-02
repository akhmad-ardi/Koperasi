<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Denda extends Model
{
    use HasFactory;

    // Nama tabel (opsional, jika sesuai konvensi Laravel bisa di-skip)
    protected $table = 'denda';

    public $timestamps = false;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_pinjaman',
        'tgl_denda',
        'jumlah_denda',
        'tgl_bayar',
        'status',
    ];

    // Format tanggal
    protected $dates = [
        'tgl_denda',
        'tgl_bayar',
    ];

    // Relasi ke Pinjaman
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }

    // Accessor untuk format tanggal denda
    public function getTglDendaFormattedAttribute()
    {
        return Carbon::parse($this->tgl_denda)->format('d-m-Y');
    }

    // Accessor untuk format tanggal bayar
    public function getTglBayarFormattedAttribute()
    {
        return $this->tgl_bayar ? Carbon::parse($this->tgl_bayar)->format('d-m-Y') : '-';
    }

    // Scope untuk denda yang belum dibayar
    public function scopeBelumBayar($query)
    {
        return $query->where('status', 'belum bayar');
    }

    // Scope untuk denda yang sudah dibayar
    public function scopeLunas($query)
    {
        return $query->where('status', 'lunas');
    }
}
