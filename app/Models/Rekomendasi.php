<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekomendasi extends Model
{
    protected $table = 'kis_rekomendasis';
    protected $primaryKey = 'id_rekomendasi';

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_by');
    }

    public function tindakLanjuts()
    {
        return $this->hasMany(
            Tindaklanjut::class,
            'id_rekomendasi',
            'id_rekomendasi'
        )->whereNull('deleted_by');
    }

    public function tindakLanjutAktif()
    {
        return $this->hasOne(
            Tindaklanjut::class,
            'id_rekomendasi',
            'id_rekomendasi'
        )->whereNull('deleted_by');
    }

    public function kasus(): BelongsTo
    {
        return $this->belongsTo(Kasus::class, 'id_kasus', 'id_kasus');
    }

    public function temuan(): BelongsTo
    {
        return $this->belongsTo(Temuan::class, 'id_temuan', 'id_temuan');
    }

    public function createdBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'created_by', 'id_pegawai');
    }

    public function editedBy()
    {
        return $this->belongsTo(PegawaiSimak::class, 'edited_by', 'id_pegawai');
    }
}
