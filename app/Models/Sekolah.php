<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    public $timestamps = false;

    protected $fillable = [
        'nama_sekolah',
        'alamat'
    ];

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'id_sekolah', 'id');
    }
}
