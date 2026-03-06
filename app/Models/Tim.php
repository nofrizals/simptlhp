<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    protected $table = 'kis_tims';
    protected $guarded = [];

    public function ketua()
    {
        return $this->belongsTo(User::class, 'nip_ketua', 'id_pegawai');
    }
}
