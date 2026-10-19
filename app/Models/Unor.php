<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unor extends Model
{
    use HasFactory;
    protected $connection = 'mysql_simak';
    protected $table = 'm_unor';
    protected $guarded = [];
    public $timestamps = false;

    public function getByKodeUnor($kode_unor)
    {
        return self::select('nama_unor')
            ->where('kode_unor', $kode_unor)
            ->first();
    }

    public function scopeInstansi($query)
    {
        return $query
            ->whereRaw('CHAR_LENGTH(kode_unor) <= ?', [5])
            ->whereRaw('RIGHT(kode_unor, 2) < ?', [59]);
    }

    public function scopeKecamatan($query)
    {
        return $query
            ->whereRaw('CHAR_LENGTH(kode_unor) = ?', [5])
            ->whereRaw('RIGHT(kode_unor, 2) >= ?', [32])
            ->whereRaw('RIGHT(kode_unor, 2) <= ?', [45]);
    }
}
