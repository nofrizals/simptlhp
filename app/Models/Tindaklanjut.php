<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tindaklanjut extends Model
{
    protected $table = 'kis_tindak_lanjuts';
    protected $primaryKey = 'id_tindak_lanjut';
    public $timestamps = false;
    protected $guarded = [];

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusTl::class, 'id_status', 'id_status');
    }

    public function createdBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'created_by', 'id_pegawai');
    }
}
