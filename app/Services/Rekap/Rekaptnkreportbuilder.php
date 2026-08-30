<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Kasus;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;

final class RekapTnkReportBuilder
{
    public function __construct(
        private readonly RekapSignatureResolver $signatureResolver,
    ) {}

    /**
     * @return array{
     *     isTgr: bool,
     *     temuanCount: int,
     *     rekomendasiCount: int,
     *     admin: array{ssr: int, bsr: int, bd: int, jumlah: int},
     *     keuangan: array{ssr: int, bsr: int, bd: int, jumlah: int},
     *     adminRatio: int,
     *     keuanganRatio: int,
     *     bk: array<int, float>,
     *     setoran: array<int, float>,
     *     ttd: \App\Models\User|null,
     *     namaObrik: string,
     * }
     */
    public function build(Kasus $kasus): array
    {
        $kasus->loadMissing(['instansi', 'jenis_php']);

        $isTgr = (int) $kasus->id_jenis_php === 7;

        $temuanCount = Temuan::query()
            ->active()
            ->where('id_kasus', $kasus->id_kasus)
            ->when($isTgr, fn($q) => $q->where('besaran_kerugian2', '>', 0))
            ->count();

        $rekomendasiCount = Rekomendasi::query()
            ->active()
            ->whereHas('temuan', function ($q) use ($kasus, $isTgr) {
                $q->active()->where('id_kasus', $kasus->id_kasus);

                if ($isTgr) {
                    $q->where('besaran_kerugian2', '>', 0);
                }
            })
            ->count();

        $besaranKerugian = Temuan::query()
            ->active()
            ->where('id_kasus', $kasus->id_kasus)
            ->selectRaw('
                SUM(besaran_kerugian) as bk1,
                SUM(besaran_kerugian2) as bk2,
                SUM(besaran_kerugian3) as bk3,
                SUM(besaran_kerugian4) as bk4
            ')
            ->first();

        $setoran = Tindaklanjut::query()
            ->whereNull('deleted_by')
            ->whereHas('rekomendasi', function ($q) use ($kasus, $isTgr) {
                $q->active()->whereHas('temuan', function ($q2) use ($kasus, $isTgr) {
                    $q2->active()->where('id_kasus', $kasus->id_kasus);

                    if ($isTgr) {
                        $q2->where('besaran_kerugian2', '>', 0);
                    }
                });
            })
            ->selectRaw('
                SUM(setor) as setoran1,
                SUM(setor2) as setoran2,
                SUM(setor3) as setoran3,
                SUM(setor4) as setoran4
            ')
            ->first();

        $admin = [
            'ssr' => $this->admCount(1, $kasus->id_kasus, $isTgr),
            'bsr' => $this->admCount(2, $kasus->id_kasus, $isTgr),
            'bd'  => $this->admCount(3, $kasus->id_kasus, $isTgr),
        ];
        $admin['jumlah'] = $admin['ssr'] + $admin['bsr'] + $admin['bd'];

        $keuangan = [
            'ssr' => $this->keuCount(1, $kasus->id_kasus, $isTgr),
            'bsr' => $this->keuCount(2, $kasus->id_kasus, $isTgr),
            'bd'  => $this->keuCount(3, $kasus->id_kasus, $isTgr),
        ];
        $keuangan['jumlah'] = $keuangan['ssr'] + $keuangan['bsr'] + $keuangan['bd'];

        $totalAdmKeu = $admin['jumlah'] + $keuangan['jumlah'];
        $adminRatio = $totalAdmKeu ? (int) round($admin['jumlah'] / $totalAdmKeu * 100) : 0;
        $keuanganRatio = $totalAdmKeu ? (int) round($keuangan['jumlah'] / $totalAdmKeu * 100) : 0;

        return [
            'isTgr'            => $isTgr,
            'temuanCount'      => $temuanCount,
            'rekomendasiCount' => $isTgr ? $temuanCount : $rekomendasiCount,
            'admin'            => $admin,
            'keuangan'         => $keuangan,
            'adminRatio'       => $adminRatio,
            'keuanganRatio'    => $keuanganRatio,
            'bk' => [
                1 => (float) ($besaranKerugian->bk1 ?? 0),
                2 => (float) ($besaranKerugian->bk2 ?? 0),
                3 => (float) ($besaranKerugian->bk3 ?? 0),
                4 => (float) ($besaranKerugian->bk4 ?? 0),
            ],
            'setoran' => [
                1 => (float) ($setoran->setoran1 ?? 0),
                2 => (float) ($setoran->setoran2 ?? 0),
                3 => (float) ($setoran->setoran3 ?? 0),
                4 => (float) ($setoran->setoran4 ?? 0),
            ],
            'ttd'       => $this->signatureResolver->getTtd(),
            'namaObrik' => $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor,
        ];
    }

    private function admCount(int $idStatus, int $idKasus, bool $isTgr): int
    {
        if ($isTgr) {
            return 0;
        }

        return Tindaklanjut::query()
            ->whereNull('deleted_by')
            ->where('id_status', $idStatus)
            ->where('rincian_keuangan', 0)
            ->where('rincian_keuangan2', 0)
            ->where('rincian_keuangan3', 0)
            ->where('rincian_keuangan4', 0)
            ->whereHas('rekomendasi', function ($q) use ($idKasus) {
                $q->active()->whereHas('temuan', function ($q2) use ($idKasus) {
                    $q2->active()->where('id_kasus', $idKasus);
                });
            })
            ->count();
    }

    private function keuCount(int $idStatus, int $idKasus, bool $isTgr): int
    {
        return Tindaklanjut::query()
            ->whereNull('deleted_by')
            ->where('id_status', $idStatus)
            ->when(
                $isTgr,
                fn($q) => $q->where('rincian_keuangan2', '>', 0),
                fn($q) => $q->where(function ($sub) {
                    $sub->where('rincian_keuangan', '>', 0)
                        ->orWhere('rincian_keuangan2', '>', 0)
                        ->orWhere('rincian_keuangan3', '>', 0)
                        ->orWhere('rincian_keuangan4', '>', 0);
                })
            )
            ->whereHas('rekomendasi', function ($q) use ($idKasus) {
                $q->active()->whereHas('temuan', function ($q2) use ($idKasus) {
                    $q2->active()->where('id_kasus', $idKasus);
                });
            })
            ->count();
    }
}
