<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kis_kontaks';
    protected $primaryKey = 'id_kontak';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'kontak',
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
