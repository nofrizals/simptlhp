<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TimAnggota extends Model
{
    use HasFactory;
    protected $table = 'kis_tim_anggota';
    protected $guarded = [];
    public $timestamps = false;

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id');
    }
}
