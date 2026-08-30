<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\PegawaiSimak;
use App\Models\User;

final class RekapSignatureResolver
{
    /**
     * Ambil data penandatangan (TTD) dari koneksi database mysql_root.
     */
    public function getTtd(): ?User
    {
        return User::query()
            ->where('tingkatan_level', 4)
            ->where('id_app', 14)
            ->first();
    }

    /**
     * Resolve nama pegawai dari NIP via koneksi mysql_simak.
     */
    public function getNamaPegawai(?string $nip): ?string
    {
        if (! $nip) {
            return null;
        }

        return PegawaiSimak::query()->find($nip)?->nama_pegawai;
    }
}
