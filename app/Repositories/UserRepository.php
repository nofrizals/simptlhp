<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByIdPegawai(string $idPegawai): ?User
    {
        return User::where('id_pegawai', $idPegawai)->first();
    }
}
