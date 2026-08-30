<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Instansi;
use App\Models\JenisPhp;
use App\Models\Kasus;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class RekapTnkKolektifReportBuilder
{
    public function __construct(
        private readonly RekapSignatureResolver $signatureResolver,
    ) {}

    /**
     * @return array{
     *     isTgr: bool,
     *     jenisPhpLabel: string,
     *     rows: Collection<int, array<string, mixed>>,
     *     totals: array<string, mixed>,
     *     ttd: \App\Models\User|null,
     * }
     */
    public function build(int $idJenisPhp, string $tahunPemeriksaan, string $kodeUnor): array
    {
        $isTgr = $idJenisPhp === 7;
        $jenisPhpLabel = JenisPhp::query()->find($idJenisPhp)?->jenis_php ?? '-';
        $namaInstansiLabel = $this->resolveNamaInstansiLabel($kodeUnor);
        $ttd = $this->signatureResolver->getTtd();

        $kasusList = $this->resolveKasusList($idJenisPhp, $tahunPemeriksaan, $kodeUnor, $isTgr);

        if ($kasusList->isEmpty()) {
            return [
                'isTgr'             => $isTgr,
                'jenisPhpLabel'     => $jenisPhpLabel,
                'namaInstansiLabel' => $namaInstansiLabel,
                'rows'              => collect(),
                'totals'            => $this->emptyTotals(),
                'ttd'               => $ttd,
            ];
        }

        $idKasusList = $kasusList->pluck('id_kasus');

        $temuanCounts = $this->batchTemuanCount($idKasusList, $isTgr);
        $rekomendasiCounts = $isTgr ? $temuanCounts : $this->batchRekomendasiCount($idKasusList);
        $besaranKerugian = $this->batchBesaranKerugian($idKasusList);
        $setoran = $this->batchSetoran($idKasusList, $isTgr);
        [$adminCounts, $keuanganCounts] = $this->batchTindakLanjutCounts($idKasusList, $isTgr);

        $rows = collect();
        $totals = $this->emptyTotals();

        foreach ($kasusList->values() as $index => $kasus) {
            $idKasus = $kasus->id_kasus;

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

            $row = [
                'no'               => $index + 1,
                'kasus'            => $kasus,
                'spt'              => $kasus->spt,
                'waktuPelaksanaan' => $this->formatWaktu($kasus),
                'nomorLhp'         => $kasus->nomor_lhp,
                'namaObrik'        => $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor,
                'tahun'            => (string) $kasus->tahun_pemeriksaan,
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

        $totalAdmKeuAll = $totals['admin']['jumlah'] + $totals['keuangan']['jumlah'];
        $totals['adminRatio'] = ($totals['admin']['jumlah'] && $totals['keuangan']['jumlah'])
            ? (int) round($totals['admin']['jumlah'] / $totalAdmKeuAll * 100) : 0;
        $totals['keuanganRatio'] = $isTgr
            ? ($totals['keuangan']['jumlah'] ? (int) round($totals['keuangan']['jumlah'] / max($totalAdmKeuAll, 1) * 100) : 0)
            : (($totals['admin']['jumlah'] && $totals['keuangan']['jumlah'])
                ? (int) round($totals['keuangan']['jumlah'] / $totalAdmKeuAll * 100) : 0);

        foreach ([1, 2, 3, 4] as $n) {
            $totals['sisa'][$n] = max($totals['bk'][$n] - $totals['setoran'][$n], 0);
        }

        return [
            'isTgr'             => $isTgr,
            'jenisPhpLabel'     => $jenisPhpLabel,
            'namaInstansiLabel' => $namaInstansiLabel,
            'rows'              => $rows,
            'totals'            => $totals,
            'ttd'               => $ttd,
        ];
    }

    private function resolveNamaInstansiLabel(string $kodeUnor): string
    {
        if ($kodeUnor === 'semua') {
            return 'SEMUA OBRIK';
        }

        $instansi = Instansi::query()->where('kode_instansi', $kodeUnor)->first();

        return $instansi?->nama_instansi ?? $kodeUnor;
    }

    /**
     * @return Collection<int, Kasus>
     */
    private function resolveKasusList(int $idJenisPhp, string $tahunPemeriksaan, string $kodeUnor, bool $isTgr): Collection
    {
        return Kasus::query()
            ->with('instansi')
            ->whereNull('deleted_by')
            ->when($tahunPemeriksaan !== 'semua', fn($q) => $q->where('tahun_pemeriksaan', $tahunPemeriksaan))
            ->when($kodeUnor !== 'semua', fn($q) => $q->where('kode_unor', $kodeUnor))
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
            ->orderBy('kode_unor')
            ->orderBy('tahun_pemeriksaan')
            ->get();
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
     * Batch admin/keuangan tindak lanjut count untuk semua kasus dalam SATU query,
     * menggantikan 6 query per kasus di versi lama (Hitung::admTindakLanjutByKasusAndStatus
     * / keuTindakLanjutByKasusAndStatus).
     *
     * @param  Collection<int, int>  $idKasusList
     * @return array{0: array<string, int>, 1: array<string, int>} [adminCounts, keuanganCounts]
     *         key format: "{id_kasus}:{id_status}"
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
            // Tipe TGR: tidak ada sisi administratif (selalu 0); keuangan hanya dari rincian_keuangan2.
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
     * @param  array<string, int>  $counts  key format "{id_kasus}:{id_status}"
     * @return array{ssr: int, bsr: int, bd: int, jumlah: int}
     */
    private function extractCounts(array $counts, int $idKasus): array
    {
        $ssr = $counts["{$idKasus}:1"] ?? 0;
        $bsr = $counts["{$idKasus}:2"] ?? 0;
        $bd = $counts["{$idKasus}:3"] ?? 0;

        return ['ssr' => $ssr, 'bsr' => $bsr, 'bd' => $bd, 'jumlah' => $ssr + $bsr + $bd];
    }

    private function formatWaktu(Kasus $kasus): string
    {
        if (!$kasus->spt_mulai) {
            return '';
        }

        return Carbon::parse($kasus->spt_mulai)->translatedFormat('d M Y')
            . ' ~ ' . Carbon::parse($kasus->spt_selesai)->translatedFormat('d M Y');
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyTotals(): array
    {
        return [
            'temuan'        => 0,
            'rekomendasi'   => 0,
            'admin'         => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'keuangan'      => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'adminRatio'    => 0,
            'keuanganRatio' => 0,
            'bk'            => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'setoran'       => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'sisa'          => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
        ];
    }
}
