<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unor extends Model
{
    use HasFactory;
    protected $connection = 'mysql_simak';
    protected $table = 'm_unor';
    protected $guarded = [];
    public $timestamps = false;
}
