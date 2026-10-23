<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Unor;
use App\Models\Instansi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class SimakUnorService
{
    public function resolveNamaKecamatan(string $kodeUnor): string
    {
        if (strlen($kodeUnor) <= 5) {
            $unor = Unor::query()->where('kode_unor', $kodeUnor)->first();

            if ($unor) {
                return (string) $unor->nama_unor;
            }
        }

        $instansi = Instansi::query()->where('kode_instansi', $kodeUnor)->first();

        return $instansi?->nama_instansi ?? $kodeUnor;
    }

    // public function listKecamatan(): Collection
    // {
    //     return Cache::remember('rekap.kecamatan-list', now()->addHours(6), function () {
    //         $query = Unor::query()
    //             ->whereRaw('CHAR_LENGTH(kode_unor) = 5')
    //             ->whereRaw('RIGHT(kode_unor, 2) >= 32')
    //             ->whereRaw('RIGHT(kode_unor, 2) <= 45');

    //         $tim = session('tim');
    //         if ($tim) {
    //             $query->where('id_tim', $tim);
    //         }

    //         return $query
    //             ->orderBy('nama_unor')
    //             ->get();
    //     });
    // }


    public function listKecamatan(): Collection
    {
        $tim = session('tim');
        $cacheKey = 'rekap.kecamatan-list.' . ($tim ?? 'semua');

        return Cache::remember(
            $cacheKey,
            now()->addHours(6),
            function () use ($tim) {
                $query = Instansi::query()
                    ->whereRaw('CHAR_LENGTH(kode_instansi) = 5')
                    ->whereRaw('RIGHT(kode_instansi, 2) >= 32')
                    ->whereRaw('RIGHT(kode_instansi, 2) <= 45');

                if ($tim !== null && $tim !== '') {
                    $query->where('id_tim', $tim);
                }

                return $query
                    ->orderBy('nama_instansi')
                    ->get();
            }
        );
    }
}
