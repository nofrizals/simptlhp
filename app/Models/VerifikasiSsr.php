<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSsr extends Model
{
    use HasFactory;
    protected $table = 'kis_ssr_approvals';
    public $timestamps = false;
    protected $guarded = [];

    public function status()
    {
        return $this->hasOne(StatusTl::class, 'id_status', 'id_status');
    }
}
