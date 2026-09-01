<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;
use Illuminate\Support\Collection;

/**
 * Menghitung metrik tindak lanjut (temuan, rekomendasi, admin, keuangan, kerugian, setoran)
 * untuk sekumpulan kasus dalam query batch (bebas N+1), bisa dipakai lintas fitur rekap.
 */
final class RekapTnkAggregator
{
    /**
     * @param  Collection<int, \App\Models\Kasus>  $kasusList
     * @return Collection<int, array<string, mixed>> keyed by id_kasus
     */
    public function aggregate(Collection $kasusList, bool $isTgr): Collection
    {
        if ($kasusList->isEmpty()) {
            return collect();
        }

        $idKasusList = $kasusList->pluck('id_kasus');

        $temuanCounts = $this->batchTemuanCount($idKasusList, $isTgr);
        $rekomendasiCounts = $isTgr ? $temuanCounts : $this->batchRekomendasiCount($idKasusList);
        $besaranKerugian = $this->batchBesaranKerugian($idKasusList);
        $setoran = $this->batchSetoran($idKasusList, $isTgr);
        [$adminCounts, $keuanganCounts] = $this->batchTindakLanjutCounts($idKasusList, $isTgr);

        $result = collect();

        foreach ($idKasusList as $idKasus) {
            $temuanCount = $temuanCounts[$idKasus] ?? 0;
            $rekomendasiCount = $rekomendasiCounts[$idKasus] ?? 0;

            $admin = $isTgr
                ? ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0]
                : $this->extractCounts($adminCounts, $idKasus);
            $keuangan = $this->extractCounts($keuanganCounts, $idKasus);

            $totalAdmKeu = $admin['jumlah'] + $keuangan['jumlah'];
            $adminRatio = $totalAdmKeu ? (int) round($admin['jumlah'] / $totalAdmKeu * 100) : 0;
            $keuanganRatio = $totalAdmKeu ? (int) round($keuangan['jumlah'] / $totalAdmKeu * 100) : 0;

            $bk = $besaranKerugian[$idKasus] ?? ['bk1' => 0.0, 'bk2' => 0.0, 'bk3' => 0.0, 'bk4' => 0.0];
            $set = $setoran[$idKasus] ?? ['setoran1' => 0.0, 'setoran2' => 0.0, 'setoran3' => 0.0, 'setoran4' => 0.0];

            $bkArr = [1 => (float) $bk['bk1'], 2 => (float) $bk['bk2'], 3 => (float) $bk['bk3'], 4 => (float) $bk['bk4']];
            $setoranArr = [1 => (float) $set['setoran1'], 2 => (float) $set['setoran2'], 3 => (float) $set['setoran3'], 4 => (float) $set['setoran4']];

            $result[$idKasus] = [
                'temuanCount'      => $temuanCount,
                'rekomendasiCount' => $rekomendasiCount,
                'admin'            => $admin,
                'keuangan'         => $keuangan,
                'adminRatio'       => $adminRatio,
                'keuanganRatio'    => $keuanganRatio,
                'bk'               => $bkArr,
                'setoran'          => $setoranArr,
                'sisa'             => [
                    1 => max($bkArr[1] - $setoranArr[1], 0),
                    2 => max($bkArr[2] - $setoranArr[2], 0),
                    3 => max($bkArr[3] - $setoranArr[3], 0),
                    4 => max($bkArr[4] - $setoranArr[4], 0),
                ],
            ];
        }

        return $result;
    }

    /**
     * @param  Collection<int, int>  $idKasusList
     * @return array<int, int>
     */
    private function batchTemuanCount(Collection $idKasusList, bool $isTgr): array
    {
        return Temuan::query()
            ->whereNull('deleted_by')
            ->whereIn('id_kasus', $idKasusList)
            ->when($isTgr, fn($q) => $q->where('besaran_kerugian2', '>', 0))
            ->selectRaw('id_kasus, COUNT(*) as jumlah')
            ->groupBy('id_kasus')
            ->pluck('jumlah', 'id_kasus')
            ->all();
    }

    /**
     * @param  Collection<int, int>  $idKasusList
     * @return array<int, int>
     */
    private function batchRekomendasiCount(Collection $idKasusList): array
    {
        $temuanTable = (new Temuan())->getTable();

        return Rekomendasi::query()
            ->whereNull('kis_rekomendasis.deleted_by')
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'kis_rekomendasis.id_temuan')
                    ->whereNull('tem.deleted_by');
            })
            ->whereIn('tem.id_kasus', $idKasusList)
            ->selectRaw('tem.id_kasus as id_kasus, COUNT(*) as jumlah')
            ->groupBy('tem.id_kasus')
            ->pluck('jumlah', 'id_kasus')
            ->all();
    }

    /**
     * @param  Collection<int, int>  $idKasusList
     * @return array<int, array{bk1: float, bk2: float, bk3: float, bk4: float}>
     */
    private function batchBesaranKerugian(Collection $idKasusList): array
    {
        return Temuan::query()
            ->whereNull('deleted_by')
            ->whereIn('id_kasus', $idKasusList)
            ->selectRaw('
                id_kasus,
                SUM(besaran_kerugian) as bk1,
                SUM(besaran_kerugian2) as bk2,
                SUM(besaran_kerugian3) as bk3,
                SUM(besaran_kerugian4) as bk4
            ')
            ->groupBy('id_kasus')
            ->get()
            ->keyBy('id_kasus')
            ->map(fn($row) => [
                'bk1' => (float) $row->bk1,
                'bk2' => (float) $row->bk2,
                'bk3' => (float) $row->bk3,
                'bk4' => (float) $row->bk4,
            ])
            ->all();
    }

    /**
     * @param  Collection<int, int>  $idKasusList
     * @return array<int, array{setoran1: float, setoran2: float, setoran3: float, setoran4: float}>
     */
    private function batchSetoran(Collection $idKasusList, bool $isTgr): array
    {
        $rekomendasiTable = (new Rekomendasi())->getTable();
        $temuanTable = (new Temuan())->getTable();

        return Tindaklanjut::query()
            ->whereNull('kis_tindak_lanjuts.deleted_by')
            ->join("{$rekomendasiTable} as rek", function ($join) {
                $join->on('rek.id_rekomendasi', '=', 'kis_tindak_lanjuts.id_rekomendasi')
                    ->whereNull('rek.deleted_by');
            })
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'rek.id_temuan')
                    ->whereNull('tem.deleted_by');
            })
            ->whereIn('tem.id_kasus', $idKasusList)
            ->when($isTgr, fn($q) => $q->where('tem.besaran_kerugian2', '>', 0))
            ->selectRaw('
                tem.id_kasus as id_kasus,
                SUM(kis_tindak_lanjuts.setor) as setoran1,
                SUM(kis_tindak_lanjuts.setor2) as setoran2,
                SUM(kis_tindak_lanjuts.setor3) as setoran3,
                SUM(kis_tindak_lanjuts.setor4) as setoran4
            ')
            ->groupBy('tem.id_kasus')
            ->get()
            ->keyBy('id_kasus')
            ->map(fn($row) => [
                'setoran1' => (float) $row->setoran1,
                'setoran2' => (float) $row->setoran2,
                'setoran3' => (float) $row->setoran3,
                'setoran4' => (float) $row->setoran4,
            ])
            ->all();
    }

    /**
     * @param  Collection<int, int>  $idKasusList
     * @return array{0: array<string, int>, 1: array<string, int>} [adminCounts, keuanganCounts], key "{id_kasus}:{id_status}"
     */
    private function batchTindakLanjutCounts(Collection $idKasusList, bool $isTgr): array
    {
        $rekomendasiTable = (new Rekomendasi())->getTable();
        $temuanTable = (new Temuan())->getTable();

        $base = Tindaklanjut::query()
            ->whereNull('kis_tindak_lanjuts.deleted_by')
            ->join("{$rekomendasiTable} as rek", function ($join) {
                $join->on('rek.id_rekomendasi', '=', 'kis_tindak_lanjuts.id_rekomendasi')
                    ->whereNull('rek.deleted_by');
            })
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'rek.id_temuan')
                    ->whereNull('tem.deleted_by');
            })
            ->whereIn('tem.id_kasus', $idKasusList);

        if ($isTgr) {
            $rows = (clone $base)
                ->where('kis_tindak_lanjuts.rincian_keuangan2', '>', 0)
                ->selectRaw('tem.id_kasus as id_kasus, kis_tindak_lanjuts.id_status as id_status, COUNT(*) as jumlah')
                ->groupBy('tem.id_kasus', 'kis_tindak_lanjuts.id_status')
                ->get();

            $keuangan = [];
            foreach ($rows as $row) {
                $keuangan["{$row->id_kasus}:{$row->id_status}"] = (int) $row->jumlah;
            }

            return [[], $keuangan];
        }

        $rows = $base
            ->selectRaw("
                tem.id_kasus as id_kasus,
                kis_tindak_lanjuts.id_status as id_status,
                CASE
                    WHEN kis_tindak_lanjuts.rincian_keuangan = 0
                     AND kis_tindak_lanjuts.rincian_keuangan2 = 0
                     AND kis_tindak_lanjuts.rincian_keuangan3 = 0
                     AND kis_tindak_lanjuts.rincian_keuangan4 = 0
                    THEN 'admin' ELSE 'keuangan'
                END as kind,
                COUNT(*) as jumlah
            ")
            ->groupBy('tem.id_kasus', 'kis_tindak_lanjuts.id_status', 'kind')
            ->get();

        $admin = [];
        $keuangan = [];

        foreach ($rows as $row) {
            $key = "{$row->id_kasus}:{$row->id_status}";
            if ($row->kind === 'admin') {
                $admin[$key] = (int) $row->jumlah;
            } else {
                $keuangan[$key] = (int) $row->jumlah;
            }
        }

        return [$admin, $keuangan];
    }

    /**
     * @param  array<string, int>  $counts key "{id_kasus}:{id_status}"
     * @return array{ssr: int, bsr: int, bd: int, jumlah: int}
     */
    private function extractCounts(array $counts, int $idKasus): array
    {
        $ssr = $counts["{$idKasus}:1"] ?? 0;
        $bsr = $counts["{$idKasus}:2"] ?? 0;
        $bd = $counts["{$idKasus}:3"] ?? 0;

        return ['ssr' => $ssr, 'bsr' => $bsr, 'bd' => $bd, 'jumlah' => $ssr + $bsr + $bd];
    }
}
