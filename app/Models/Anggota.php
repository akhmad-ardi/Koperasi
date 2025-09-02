<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau nama tabel sesuai plural)
    protected $table = 'anggota';

    // Primary key
    protected $primaryKey = 'id';

    // Kalau tidak pakai timestamps (created_at & updated_at)
    public $timestamps = false;

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'id_sekolah',
        'no_anggota',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'pekerjaan',
        'alamat',
        'no_telepon',
        'nik',
        'nip',
        'foto_diri',
        'status',
        'tgl_gabung',
    ];

    // Relasi ke tabel sekolah
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'id_anggota', 'id');
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_anggota', 'id');
    }

    public function penarikan()
    {
        return $this->hasMany(Penarikan::class, 'id_anggota', 'id');
    }
}
