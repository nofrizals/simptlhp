<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPhp extends Model
{
    use HasFactory;
    protected $table = 'kis_jenis_phps';
    protected $primaryKey = 'id_jenis_php';
    public $timestamps = false;
    protected $guarded = [];
}
