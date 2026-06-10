<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByNip(string $idPegawai): ?User
    {
        return User::where('id_pegawai', $idPegawai)->first();
    }
}
