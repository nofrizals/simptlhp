<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Rekomendasi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Temuan extends Model
{
    protected $table = 'kis_temuans';
    protected $primaryKey = 'id_temuan';
    public $timestamps = false;

    protected $fillable = [
        'id_kasus',
        'temuan',
        'id_nilai_kerugian',
        'besaran_kerugian',
        'id_nilai_kerugian2',
        'besaran_kerugian2',
        'id_nilai_kerugian3',
        'besaran_kerugian3',
        'id_nilai_kerugian4',
        'besaran_kerugian4',
        'penyebab',
        'created_at',
        'created_by',
        'edited_at',
        'edited_by',
    ];

    protected function casts(): array
    {
        return [
            'besaran_kerugian'  => 'decimal:2',
            'besaran_kerugian2' => 'decimal:2',
            'besaran_kerugian3' => 'decimal:2',
            'besaran_kerugian4' => 'decimal:2',
            'created_at'        => 'datetime',
            'edited_at'         => 'datetime',
            'deleted_at'        => 'datetime',
        ];
    }

    public function kasus(): BelongsTo
    {
        return $this->belongsTo(Kasus::class, 'id_kasus', 'id_kasus');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_by');
    }

    public function rekomendasi(): HasMany
    {
        return $this->hasMany(Rekomendasi::class, 'id_temuan', 'id_temuan');
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
