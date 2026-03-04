<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;
    protected $table = 'kis_levels';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $connection = 'mysql_root';
}
