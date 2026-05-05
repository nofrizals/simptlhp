<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTl extends Model
{
    use HasFactory;
    protected $table = 'kis_status';
    protected $primaryKey = 'id_status';
    public $timestamps = false;
    protected $guarded = [];
}
