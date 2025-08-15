<?php

namespace App\Utils;

use Carbon\Carbon;

class Helper
{
    public static function stringToRupiah($angka)
    {
        $angka = (int) $angka; // Pastikan angka
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }

    public static function getTanggalAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
