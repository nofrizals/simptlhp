<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kasus extends Model
{
    use HasFactory;
    protected $table = 'kis_kasus';
    protected $primaryKey = 'id_kasus';
    public $timestamps = false;
    protected $guarded = [];
    public const SEARCHABLE_COLUMNS = [
        'nama_unor'
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

    public function getIdKasusByRekomendasi($id_rekomendasi)
    {
        return DB::table('kis_kasus as k')
            ->select('k.id_kasus')
            ->join('kis_temuans as t', 'k.id_kasus', '=', 't.id_kasus')
            ->join('kis_rekomendasis as r', 't.id_temuan', '=', 'r.id_temuan')
            ->where('r.id_rekomendasi', $id_rekomendasi)
            ->first();
    }
}
