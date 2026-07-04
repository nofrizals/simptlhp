<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obrik extends Model
{
    use HasFactory;
    protected $table = 'kis_instansis';
    protected $primaryKey = 'id_instansi';
    public $timestamps = false;
    protected $guarded = [];
    public const SEARCHABLE_COLUMNS = [
        'nama_instansi'
    ];

    public static function getLastKode($key)
    {
        $max = self::where('kode_instansi', 'like', $key . '%')
            ->whereRaw('CHAR_LENGTH(TRIM(kode_instansi)) = 8')
            ->selectRaw('MAX(CAST(RIGHT(kode_instansi,2) AS UNSIGNED)) as max')
            ->value('max');

        return ($max ?? 0) + 1;
    }
}
