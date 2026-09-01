<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Kasus;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;
use Illuminate\Support\Collection;

final class RekapPertahunReportBuilder
{
    public function __construct(
        private readonly RekapSignatureResolver $signatureResolver,
    ) {}

    /**
     * @return array{
     *     isTgr: bool,
     *     judulJenis: string,
     *     subJudul: string,
     *     rows: Collection<int, array<string, mixed>>,
     *     totals: array<string, mixed>,
     *     ttd: \App\Models\User|null,
     * }
     */
    public function build(int $idJenisPhp): array
    {
        $isTgr = $idJenisPhp === 7;
        $ttd = $this->signatureResolver->getTtd();

        $judulJenis = match ($idJenisPhp) {
            1 => ' (REGULER)',
            2 => ' (ADD)',
            default => '',
        };

        $subJudul = match ($idJenisPhp) {
            1 => 'PADA OPD DI LINGKUNGAN KABUPATEN SIAK',
            2 => 'PADA KAMPUNG SE-KABUPATEN SIAK',
            default => '',
        };

        $tahunList = $this->resolveTahunList($idJenisPhp, $isTgr);

        if ($tahunList->isEmpty()) {
            return [
                'isTgr'      => $isTgr,
                'judulJenis' => $judulJenis,
                'subJudul'   => $subJudul,
                'rows'       => collect(),
                'totals'     => $this->emptyTotals(),
                'ttd'        => $ttd,
            ];
        }

        $temuanCounts = $this->batchTemuanCount($tahunList, $idJenisPhp, $isTgr);
        $rekomendasiCounts = $this->batchRekomendasiCount($tahunList, $idJenisPhp, $isTgr);
        $besaranKerugian = $this->batchBesaranKerugian($tahunList, $idJenisPhp, $isTgr);
        $setoran = $this->batchSetoran($tahunList, $idJenisPhp, $isTgr);
        [$adminCounts, $keuanganCounts] = $this->batchTindakLanjutCounts($tahunList, $idJenisPhp, $isTgr);

        $rows = collect();
        $totals = $this->emptyTotals();

        foreach ($tahunList as $tahun) {
            $temuanCount = $temuanCounts[$tahun] ?? 0;
            $rekomendasiCount = $rekomendasiCounts[$tahun] ?? 0;

            // $admin = $isTgr
            //     ? ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0]
            //     : $this->extractCounts($adminCounts, $tahun);
            // $keuangan = $this->extractCounts($keuanganCounts, $tahun);

            $admin = $isTgr
                ? ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0]
                : $this->extractCounts($adminCounts, (string) $tahun);
            $keuangan = $this->extractCounts($keuanganCounts, (string) $tahun);


            $bk = $besaranKerugian[$tahun] ?? ['bk1' => 0.0, 'bk2' => 0.0, 'bk3' => 0.0, 'bk4' => 0.0];
            $set = $setoran[$tahun] ?? ['setoran1' => 0.0, 'setoran2' => 0.0, 'setoran3' => 0.0, 'setoran4' => 0.0];

            $bkArr = [1 => (float) $bk['bk1'], 2 => (float) $bk['bk2'], 3 => (float) $bk['bk3'], 4 => (float) $bk['bk4']];
            $setoranArr = [1 => (float) $set['setoran1'], 2 => (float) $set['setoran2'], 3 => (float) $set['setoran3'], 4 => (float) $set['setoran4']];

            $row = [
                'tahun'            => (string) $tahun,
                'temuanCount'      => $temuanCount,
                'rekomendasiCount' => $rekomendasiCount,
                'admin'            => $admin,
                'keuangan'         => $keuangan,
                'adminRatios'      => $this->withinGroupRatios($admin),
                'keuanganRatios'   => $this->withinGroupRatios($keuangan),
                'bk'               => $bkArr,
                'setoran'          => $setoranArr,
                'sisa'             => [
                    1 => max($bkArr[1] - $setoranArr[1], 0),
                    2 => max($bkArr[2] - $setoranArr[2], 0),
                    3 => max($bkArr[3] - $setoranArr[3], 0),
                    4 => max($bkArr[4] - $setoranArr[4], 0),
                ],
            ];

            $rows->push($row);

            $totals['temuan'] += $temuanCount;
            $totals['rekomendasi'] += $rekomendasiCount;
            foreach (['ssr', 'bsr', 'bd', 'jumlah'] as $k) {
                $totals['admin'][$k] += $admin[$k];
                $totals['keuangan'][$k] += $keuangan[$k];
            }
            foreach ([1, 2, 3, 4] as $n) {
                $totals['bk'][$n] += $bkArr[$n];
                $totals['setoran'][$n] += $setoranArr[$n];
            }
        }

        $totals['adminRatios'] = $this->withinGroupRatios($totals['admin']);
        $totals['keuanganRatios'] = $this->withinGroupRatios($totals['keuangan']);

        foreach ([1, 2, 3, 4] as $n) {
            $totals['sisa'][$n] = max($totals['bk'][$n] - $totals['setoran'][$n], 0);
        }

        return [
            'isTgr'      => $isTgr,
            'judulJenis' => $judulJenis,
            'subJudul'   => $subJudul,
            'rows'       => $rows,
            'totals'     => $totals,
            'ttd'        => $ttd,
        ];
    }

    /**
     * @return Collection<int, string>
     */
    private function resolveTahunList(int $idJenisPhp, bool $isTgr): Collection
    {
        return Kasus::query()
            ->whereNull('deleted_by')
            ->when($isTgr, function ($q) {
                $q->whereHas('temuans', function ($q2) {
                    $q2->whereNull('deleted_by')->where('besaran_kerugian2', '>', 0);
                });
            })
            ->when(!$isTgr, function ($q) use ($idJenisPhp) {
                in_array($idJenisPhp, [1, 4, 6], true)
                    ? $q->whereIn('id_jenis_php', [1, 4, 6])
                    : $q->where('id_jenis_php', $idJenisPhp);
            })
            ->select('tahun_pemeriksaan')
            ->distinct()
            ->orderBy('tahun_pemeriksaan')
            ->pluck('tahun_pemeriksaan');
    }

    private function applyKasusScope($query, string $kasusAlias, int $idJenisPhp, bool $isTgr): void
    {
        // TGR dibedakan lewat besaran_kerugian2 pada temuan, bukan id_jenis_php kasus —
        // konsisten dipakai di semua sub-query (fix dari bug non-deterministik di CI).
        if ($isTgr) {
            return;
        }

        in_array($idJenisPhp, [1, 4, 6], true)
            ? $query->whereIn("{$kasusAlias}.id_jenis_php", [1, 4, 6])
            : $query->where("{$kasusAlias}.id_jenis_php", $idJenisPhp);
    }

    /**
     * @param  Collection<int, string>  $tahunList
     * @return array<string, int>
     */
    private function batchTemuanCount(Collection $tahunList, int $idJenisPhp, bool $isTgr): array
    {
        $kasusTable = (new Kasus())->getTable();

        $query = Temuan::query()
            ->whereNull('kis_temuans.deleted_by')
            ->join("{$kasusTable} as kas", function ($join) {
                $join->on('kas.id_kasus', '=', 'kis_temuans.id_kasus')->whereNull('kas.deleted_by');
            })
            ->whereIn('kas.tahun_pemeriksaan', $tahunList)
            ->when($isTgr, fn($q) => $q->where('kis_temuans.besaran_kerugian2', '>', 0));

        $this->applyKasusScope($query, 'kas', $idJenisPhp, $isTgr);

        return $query
            ->selectRaw('kas.tahun_pemeriksaan as tahun, COUNT(DISTINCT kis_temuans.id_temuan) as jumlah')
            ->groupBy('kas.tahun_pemeriksaan')
            ->pluck('jumlah', 'tahun')
            ->all();
    }

    /**
     * @param  Collection<int, string>  $tahunList
     * @return array<string, int>
     */
    private function batchRekomendasiCount(Collection $tahunList, int $idJenisPhp, bool $isTgr): array
    {
        $kasusTable = (new Kasus())->getTable();
        $temuanTable = (new Temuan())->getTable();

        $query = Rekomendasi::query()
            ->whereNull('kis_rekomendasis.deleted_by')
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'kis_rekomendasis.id_temuan')->whereNull('tem.deleted_by');
            })
            ->join("{$kasusTable} as kas", function ($join) {
                $join->on('kas.id_kasus', '=', 'tem.id_kasus')->whereNull('kas.deleted_by');
            })
            ->whereIn('kas.tahun_pemeriksaan', $tahunList)
            ->when($isTgr, fn($q) => $q->where('tem.besaran_kerugian2', '>', 0));

        $this->applyKasusScope($query, 'kas', $idJenisPhp, $isTgr);

        return $query
            ->selectRaw('kas.tahun_pemeriksaan as tahun, COUNT(DISTINCT kis_rekomendasis.id_rekomendasi) as jumlah')
            ->groupBy('kas.tahun_pemeriksaan')
            ->pluck('jumlah', 'tahun')
            ->all();
    }

    /**
     * @param  Collection<int, string>  $tahunList
     * @return array<string, array{bk1: float, bk2: float, bk3: float, bk4: float}>
     */
    private function batchBesaranKerugian(Collection $tahunList, int $idJenisPhp, bool $isTgr): array
    {
        $kasusTable = (new Kasus())->getTable();

        $query = Temuan::query()
            ->whereNull('kis_temuans.deleted_by')
            ->join("{$kasusTable} as kas", function ($join) {
                $join->on('kas.id_kasus', '=', 'kis_temuans.id_kasus')->whereNull('kas.deleted_by');
            })
            ->whereIn('kas.tahun_pemeriksaan', $tahunList);

        $this->applyKasusScope($query, 'kas', $idJenisPhp, $isTgr);

        return $query
            ->selectRaw('
                kas.tahun_pemeriksaan as tahun,
                SUM(kis_temuans.besaran_kerugian) as bk1,
                SUM(kis_temuans.besaran_kerugian2) as bk2,
                SUM(kis_temuans.besaran_kerugian3) as bk3,
                SUM(kis_temuans.besaran_kerugian4) as bk4
            ')
            ->groupBy('kas.tahun_pemeriksaan')
            ->get()
            ->keyBy('tahun')
            ->map(fn($row) => [
                'bk1' => (float) $row->bk1,
                'bk2' => (float) $row->bk2,
                'bk3' => (float) $row->bk3,
                'bk4' => (float) $row->bk4,
            ])
            ->all();
    }

    /**
     * @param  Collection<int, string>  $tahunList
     * @return array<string, array{setoran1: float, setoran2: float, setoran3: float, setoran4: float}>
     */
    private function batchSetoran(Collection $tahunList, int $idJenisPhp, bool $isTgr): array
    {
        $kasusTable = (new Kasus())->getTable();
        $rekomendasiTable = (new Rekomendasi())->getTable();
        $temuanTable = (new Temuan())->getTable();

        $query = Tindaklanjut::query()
            ->whereNull('kis_tindak_lanjuts.deleted_by')
            ->join("{$rekomendasiTable} as rek", function ($join) {
                $join->on('rek.id_rekomendasi', '=', 'kis_tindak_lanjuts.id_rekomendasi')->whereNull('rek.deleted_by');
            })
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'rek.id_temuan')->whereNull('tem.deleted_by');
            })
            ->join("{$kasusTable} as kas", function ($join) {
                $join->on('kas.id_kasus', '=', 'tem.id_kasus')->whereNull('kas.deleted_by');
            })
            ->whereIn('kas.tahun_pemeriksaan', $tahunList)
            ->when($isTgr, fn($q) => $q->where('tem.besaran_kerugian2', '>', 0));

        $this->applyKasusScope($query, 'kas', $idJenisPhp, $isTgr);

        return $query
            ->selectRaw('
                kas.tahun_pemeriksaan as tahun,
                SUM(kis_tindak_lanjuts.setor) as setoran1,
                SUM(kis_tindak_lanjuts.setor2) as setoran2,
                SUM(kis_tindak_lanjuts.setor3) as setoran3,
                SUM(kis_tindak_lanjuts.setor4) as setoran4
            ')
            ->groupBy('kas.tahun_pemeriksaan')
            ->get()
            ->keyBy('tahun')
            ->map(fn($row) => [
                'setoran1' => (float) $row->setoran1,
                'setoran2' => (float) $row->setoran2,
                'setoran3' => (float) $row->setoran3,
                'setoran4' => (float) $row->setoran4,
            ])
            ->all();
    }

    /**
     * @param  Collection<int, string>  $tahunList
     * @return array{0: array<string, int>, 1: array<string, int>} [adminCounts, keuanganCounts], key "{tahun}:{id_status}"
     */
    private function batchTindakLanjutCounts(Collection $tahunList, int $idJenisPhp, bool $isTgr): array
    {
        $kasusTable = (new Kasus())->getTable();
        $rekomendasiTable = (new Rekomendasi())->getTable();
        $temuanTable = (new Temuan())->getTable();

        $base = Tindaklanjut::query()
            ->whereNull('kis_tindak_lanjuts.deleted_by')
            ->join("{$rekomendasiTable} as rek", function ($join) {
                $join->on('rek.id_rekomendasi', '=', 'kis_tindak_lanjuts.id_rekomendasi')->whereNull('rek.deleted_by');
            })
            ->join("{$temuanTable} as tem", function ($join) {
                $join->on('tem.id_temuan', '=', 'rek.id_temuan')->whereNull('tem.deleted_by');
            })
            ->join("{$kasusTable} as kas", function ($join) {
                $join->on('kas.id_kasus', '=', 'tem.id_kasus')->whereNull('kas.deleted_by');
            })
            ->whereIn('kas.tahun_pemeriksaan', $tahunList);

        $this->applyKasusScope($base, 'kas', $idJenisPhp, $isTgr);

        if ($isTgr) {
            $rows = (clone $base)
                ->where('kis_tindak_lanjuts.rincian_keuangan2', '>', 0)
                ->selectRaw('kas.tahun_pemeriksaan as tahun, kis_tindak_lanjuts.id_status as id_status, COUNT(*) as jumlah')
                ->groupBy('kas.tahun_pemeriksaan', 'kis_tindak_lanjuts.id_status')
                ->get();

            $keuangan = [];
            foreach ($rows as $row) {
                $keuangan["{$row->tahun}:{$row->id_status}"] = (int) $row->jumlah;
            }

            return [[], $keuangan];
        }

        $rows = $base
            ->selectRaw("
                kas.tahun_pemeriksaan as tahun,
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
            ->groupBy('kas.tahun_pemeriksaan', 'kis_tindak_lanjuts.id_status', 'kind')
            ->get();

        $admin = [];
        $keuangan = [];

        foreach ($rows as $row) {
            $key = "{$row->tahun}:{$row->id_status}";
            if ($row->kind === 'admin') {
                $admin[$key] = (int) $row->jumlah;
            } else {
                $keuangan[$key] = (int) $row->jumlah;
            }
        }

        return [$admin, $keuangan];
    }

    /**
     * @param  array<string, int>  $counts key "{tahun}:{id_status}"
     * @return array{ssr: int, bsr: int, bd: int, jumlah: int}
     */
    private function extractCounts(array $counts, string $tahun): array
    {
        $ssr = $counts["{$tahun}:1"] ?? 0;
        $bsr = $counts["{$tahun}:2"] ?? 0;
        $bd = $counts["{$tahun}:3"] ?? 0;

        return ['ssr' => $ssr, 'bsr' => $bsr, 'bd' => $bd, 'jumlah' => $ssr + $bsr + $bd];
    }

    /**
     * Rasio SSR/BSR/BD terhadap total dalam kategorinya sendiri (admin thd total admin,
     * keuangan thd total keuangan) — BUKAN terhadap gabungan admin+keuangan.
     *
     * @param  array{ssr: int, bsr: int, bd: int, jumlah: int}  $counts
     * @return array{ssr: int, bsr: int, bd: int}
     */
    private function withinGroupRatios(array $counts): array
    {
        $jumlah = $counts['jumlah'];
        $pct = fn(int $v) => $jumlah ? (int) round($v / $jumlah * 100) : 0;

        return ['ssr' => $pct($counts['ssr']), 'bsr' => $pct($counts['bsr']), 'bd' => $pct($counts['bd'])];
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyTotals(): array
    {
        return [
            'temuan'         => 0,
            'rekomendasi'    => 0,
            'admin'          => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'keuangan'       => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'adminRatios'    => ['ssr' => 0, 'bsr' => 0, 'bd' => 0],
            'keuanganRatios' => ['ssr' => 0, 'bsr' => 0, 'bd' => 0],
            'bk'             => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'setoran'        => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'sisa'           => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
        ];
    }
}
