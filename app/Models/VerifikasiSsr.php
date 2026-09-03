<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSsr extends Model
{
    use HasFactory;
    protected $table = 'kis_ssr_approvals';
    public $timestamps = false;
    protected $guarded = [];
    public const SEARCHABLE_COLUMNS = [
        'tindak_lanjut'
    ];

    public function status()
    {
        return $this->hasOne(StatusTl::class, 'id_status', 'id_status');
    }

    public function approveBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'approve_by', 'id_pegawai');
    }

    public function rejectBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'reject_by', 'id_pegawai');
    }

    public function createdBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'created_by', 'id_pegawai');
    }

    public function editedBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'edited_by', 'id_pegawai');
    }

    public function tindakLanjut()
    {
        return $this->belongsTo(Tindaklanjut::class, 'id_tindak_lanjut', 'id_tindak_lanjut');
    }

    public function rekomendasi()
    {
        return $this->belongsTo(Rekomendasi::class, 'id_rekomendasi', 'id_rekomendasi');
    }
}
