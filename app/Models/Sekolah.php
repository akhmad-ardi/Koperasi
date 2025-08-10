<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'sekolah';

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'id_sekolah', 'id');
    }
}
