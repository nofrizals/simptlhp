<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NamaOpdService
{
    public function resolveByKodeUnor(string $kodeUnor): string
    {
        if (blank($kodeUnor)) {
            return '';
        }

        // Untuk kode pendek (≤5 karakter), query dari DB simak
        if (strlen($kodeUnor) <= 5) {
            $result = DB::connection('mysql_simak')
                ->table('m_unor')
                ->select('nama_unor')
                ->where('kode_unor', $kodeUnor)
                ->first();

            if ($result) {
                return $result->nama_unor;
            }
        }

        // Fallback ke tabel instansi
        // TODO: sesuaikan nama tabel & kolom jika berbeda
        $instansi = DB::connection('mysql_root')
            ->table('kis_instansis')
            ->select('nama_instansi')
            ->where('kode_instansi', $kodeUnor)
            ->first();

        return $instansi?->nama_instansi ?? $kodeUnor;
    }
}
