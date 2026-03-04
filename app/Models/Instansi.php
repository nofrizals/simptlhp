<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instansi extends Model
{
    use HasFactory;
    protected $table = 'kis_instansis';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'kode_unor', 'kode_instansi');
    }

    public function getNamaBersihAttribute(): string
    {
        $nama = $this->nama_instansi ?? '-';

        $words = explode(' ', $nama);
        $words = array_map(function ($word) {
            // Jika kata mengandung /, split dulu
            if (str_contains($word, '/')) {
                $parts = explode('/', $word);
                $parts = array_map(function ($part) {
                    return preg_match('/^[IVXLCDM]+$/i', $part)
                        ? strtoupper($part)
                        : ucfirst(strtolower($part));
                }, $parts);
                return implode('/', $parts);
            }

            // Kata biasa
            return preg_match('/^[IVXLCDM]{1,4}$/i', $word)
                ? strtoupper($word)
                : ucfirst(strtolower($word));
        }, $words);

        return implode(' ', $words);
    }
}
