<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKerugian extends Model
{
    use HasFactory;
    protected $table = 'kis_nilai_kerugians';
    protected $primaryKey = 'id_nilai_kerugian';
    public $timestamps = false;
    protected $guarded = [];
    public const SEARCHABLE_COLUMNS = [
        'nilai_kerugian'
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
