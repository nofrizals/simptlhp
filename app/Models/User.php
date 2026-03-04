<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
    protected $table = 'kis_users';
    protected $guarded = [];
    public $timestamps = false;
    protected $connection = 'mysql_root';

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'kode_unor', 'kode_instansi');
    }

    public function getNamaBersihAttribute(): string
    {
        if (! $this->nama_pegawai) {
            return '';
        }

        $parts = explode(',', $this->nama_pegawai, 2);
        $nama = preg_replace('/^[-\s]+/', '', $parts[0]);
        $nama = trim($nama);
        $nama = ucwords(strtolower($nama));

        if (isset($parts[1])) {
            $gelar = trim($parts[1]);
            return $nama . ', ' . $gelar;
        }

        return $nama;
    }
}
