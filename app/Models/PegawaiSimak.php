<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiSimak extends Model
{
    protected $connection = 'mysql_simak';
    protected $table      = 'r_pegawai_aktual';
    public const SEARCHABLE_COLUMNS = [
        'a.nomenklatur_pada',
        'a.nama_pegawai',
        'a.nip_baru',
    ];
}
