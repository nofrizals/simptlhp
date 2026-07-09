<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instansi_root extends Model
{
    use HasFactory;
    protected $table = 'kis_instansis';
    protected $primaryKey = 'id_instansi';
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'mysql_root';
}
