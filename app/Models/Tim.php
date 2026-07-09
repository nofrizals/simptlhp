<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;
    protected $table = 'kis_tims';
    public $timestamps = false;
    protected $guarded = [];

    public function ketua()
    {
        return $this->belongsTo(User::class, 'nip_ketua', 'id_pegawai');
    }

    public function anggota()
    {
        return $this->hasMany(TimAnggota::class, 'id_tim', 'id');
    }

    public function instansis()
    {
        return $this->hasMany(Instansi::class, 'id_tim', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function editedBy()
    {
        return $this->belongsTo(User::class, 'edited_by', 'id_user');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id_user');
    }
}
