<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Instansi;
use App\Models\Unor;
use Illuminate\Support\Collection;

final class SimakUnorService
{
    /**
     * Replikasi Simak::getByKodeUnor() (CI): coba resolve dari `m_unor` (mysql_simak)
     * untuk kode setingkat kecamatan (<=5 karakter), fallback ke `kis_instansis`,
     * dan terakhir kembalikan kode mentah kalau semua gagal.
     */
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

    /**
     * Replikasi Simak_model::readKecamatan() — daftar kecamatan untuk dropdown filter.
     *
     * @return Collection<int, Unor>
     */
    public function listKecamatan(): Collection
    {
        return Unor::query()
            ->whereRaw('CHAR_LENGTH(kode_unor) = 5')
            ->whereRaw('RIGHT(kode_unor, 2) >= 32')
            ->whereRaw('RIGHT(kode_unor, 2) <= 45')
            ->orderBy('nama_unor')
            ->get();
    }
}
