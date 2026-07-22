<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kasus extends Model
{
    use HasFactory;
    protected $table = 'kis_kasus';
    protected $primaryKey = 'id_kasus';
    public $timestamps = false;
    protected $guarded = [];
    public const SEARCHABLE_COLUMNS = [
        'tahun_pemeriksaan'
    ];

    public function jenis_php()
    {
        return $this->hasOne(JenisPhp::class, 'id_jenis_php', 'id_jenis_php');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'kode_unor', 'kode_instansi');
    }

    public function temuans(): HasMany
    {
        return $this->hasMany(Temuan::class, 'id_kasus', 'id_kasus');
    }
}
