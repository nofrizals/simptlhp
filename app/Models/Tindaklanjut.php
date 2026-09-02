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

    public function rekomendasi(): belongsTo
    {
        return $this->belongsTo(Rekomendasi::class, 'id_rekomendasi', 'id_rekomendasi');
    }

    public function editedBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'edited_by', 'id_pegawai');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_tindak_lanjut', 'id_tindak_lanjut')->whereNull('deleted_by');
    }

    public function ssr()
    {
        return $this->belongsTo(VerifikasiSsr::class, 'id_rekomendasi', 'id_rekomendasi');
    }
}
