<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table = 'kis_access_log';
    protected $primaryKey = 'id_session';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id_session',
        'id_pegawai',
        'kode_unor',
        'level',
        'login_at',
        'valid_thru',
        'logout_at',
        'browser',
        'platform',
    ];
    protected $casts = [
        'login_at'   => 'datetime',
        'valid_thru' => 'datetime',
        'logout_at'  => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(PegawaiSimak::class, 'id_pegawai', 'id_pegawai');
    }

    public function unor()
    {
        return $this->belongsTo(Unor::class, 'kode_unor', 'kode_unor');
    }

    public function level_user()
    {
        return $this->belongsTo(Level::class, 'level', 'tingkatan_level')->where('id_app', 14);
    }
}
