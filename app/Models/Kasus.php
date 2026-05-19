<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;
    protected $table = 'kis_kasus';
    protected $primaryKey = 'id_kasus';
    public $timestamps = false;
    protected $guarded = [];
}
