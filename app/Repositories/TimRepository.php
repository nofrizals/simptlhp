<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tim;
use App\Models\TimAnggota;

class TimRepository
{
    public function findByIdUser(int|string $idUser): ?TimAnggota
    {
        return TimAnggota::select('kis_tim_anggota.*', 'kis_tims.name', 'kis_tims.nip_ketua')
            ->join('kis_tims', 'kis_tim_anggota.id_tim', '=', 'kis_tims.id')
            ->where('kis_tim_anggota.id_user', $idUser)
            ->first();
    }

    public function findByNipKetua(string $nipKetua): ?Tim
    {
        return Tim::where('nip_ketua', $nipKetua)->first();
    }
}
