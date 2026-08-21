<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    protected $table = 'kis_peraturans';
    protected $primaryKey = 'id_peraturan';
    public $timestamps = false;
    protected $fillable = [
        'judul',
        'keterangan',
        'file',
        'created_at',
        'created_by',
        'edited_at',
        'edited_by',
        'deleted_at',
        'deleted_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'created_by', 'id_pegawai');
    }

    public function editedBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'edited_by', 'id_pegawai');
    }
}
