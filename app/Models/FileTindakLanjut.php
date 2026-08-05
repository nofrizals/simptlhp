<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileTindakLanjut extends Model
{
    protected $table = 'kis_file_tindak_lanjuts';
    public $timestamps = false;
    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'created_by', 'id_pegawai');
    }
}
