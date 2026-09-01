<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Instansi;
use App\Models\Kasus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class RekapApbkamReportBuilder
{
    public function __construct(
        private readonly RekapTnkAggregator $aggregator,
        private readonly SimakUnorService $simakUnorService,
        private readonly RekapSignatureResolver $signatureResolver,
    ) {}

    /**
     * @return array{
     *     kecamatanLabel: string,
     *     tahunPemeriksaan: string,
     *     kampungRows: Collection<int, array<string, mixed>>,
     *     grandTotal: array<string, mixed>,
     *     ttd: \App\Models\User|null,
     * }
     */
    public function build(string $tahunPemeriksaan, string $kodeUnor): array
    {
        $kecamatanLabel = $this->simakUnorService->resolveNamaKecamatan($kodeUnor);
        $ttd = $this->signatureResolver->getTtd();
        $kampungList = $this->resolveKampungList($kodeUnor);

        $kampungRows = collect();
        $grandTotal = $this->emptyTotals();

        foreach ($kampungList as $index => $kampung) {
            $kasusList = $this->resolveKasusListForKampung($tahunPemeriksaan, $kampung->kode_turunan);
            $rowsForKampung = collect();
            $kampungTotal = $this->emptyTotals();

            if ($kasusList->isNotEmpty()) {
                $metrics = $this->aggregator->aggregate($kasusList, false);

                foreach ($kasusList as $kasus) {
                    $m = $metrics[$kasus->id_kasus];

                    $row = $m + [
                        'tahun'  => (string) $kasus->tahun_pemeriksaan,
                        'ratios' => $this->statusRatios($m['admin'], $m['keuangan']),
                    ];

                    $rowsForKampung->push($row);
                    $kampungTotal = $this->addKasusMetrics($kampungTotal, $m);
                }
            }

            $kampungTotal['ratios'] = $this->statusRatios($kampungTotal['admin'], $kampungTotal['keuangan']);
            $grandTotal = $this->mergeTotals($grandTotal, $kampungTotal);

            $kampungRows->push([
                'no'          => $index + 1,
                'namaKampung' => $kampung->nama_instansi,
                'rows'        => $rowsForKampung,
                'totals'      => $kampungTotal,
            ]);
        }

        // Kejanggalan sengaja direplikasi dari CI: baris TOTAL (grand total) memakai
        // rasio admin/keuangan KESELURUHAN untuk ketiga kolom SSR/BSR/BD (bukan per-status),
        // beda dengan baris per-kasus & subtotal per-kampung yang rasionya per-status.
        $totalAdmKeu = $grandTotal['admin']['jumlah'] + $grandTotal['keuangan']['jumlah'];
        $overallAdminRatio = $totalAdmKeu ? (int) round($grandTotal['admin']['jumlah'] / $totalAdmKeu * 100) : 0;
        $overallKeuanganRatio = $totalAdmKeu ? (int) round($grandTotal['keuangan']['jumlah'] / $totalAdmKeu * 100) : 0;

        $grandTotal['ratios'] = [
            'admin'    => ['ssr' => $overallAdminRatio, 'bsr' => $overallAdminRatio, 'bd' => $overallAdminRatio],
            'keuangan' => ['ssr' => $overallKeuanganRatio, 'bsr' => $overallKeuanganRatio, 'bd' => $overallKeuanganRatio],
        ];

        return [
            'kecamatanLabel'   => $kecamatanLabel,
            'tahunPemeriksaan' => $tahunPemeriksaan,
            'kampungRows'      => $kampungRows,
            'grandTotal'       => $grandTotal,
            'ttd'              => $ttd,
        ];
    }

    /**
     * Replikasi Minstansi::queryGetMyTurunanById() — daftar kampung (instansi anak,
     * kode 8 digit) di bawah satu kecamatan.
     *
     * @return Collection<int, object{nama_instansi: string, kode_turunan: string}>
     */
    private function resolveKampungList(string $kodeUnor): Collection
    {
        return Instansi::query()
            ->select('nama_instansi', DB::raw('LEFT(kode_instansi, 8) as kode_turunan'))
            ->whereRaw('CHAR_LENGTH(TRIM(kode_instansi)) = 8')
            ->where('kode_instansi', 'like', $kodeUnor . '%')
            ->get();
    }

    /**
     * Replikasi persis dua jalur data CI (termasuk inkonsistensinya):
     * - "Semua Tahun" → allTahunByObrik(2, $kodeTurunan): id_jenis_php=2 (ADD), kode_unor EXACT.
     * - Tahun spesifik → allTnkByTahunNObrik($tahun, $kodeTurunan): TANPA filter id_jenis_php,
     *   kode_unor pakai LIKE prefix.
     *
     * @return Collection<int, Kasus>
     */
    private function resolveKasusListForKampung(string $tahunPemeriksaan, string $kodeTurunan): Collection
    {
        if ($tahunPemeriksaan === 'semua') {
            return Kasus::query()
                ->whereNull('deleted_by')
                ->where('id_jenis_php', 2)
                ->where('kode_unor', $kodeTurunan)
                ->orderBy('tahun_pemeriksaan')
                ->get();
        }

        return Kasus::query()
            ->whereNull('deleted_by')
            ->where('tahun_pemeriksaan', $tahunPemeriksaan)
            ->where('kode_unor', 'like', $kodeTurunan . '%')
            ->orderBy('tahun_pemeriksaan')
            ->get();
    }

    /**
     * Rasio per-status (SSR/BSR/BD) terhadap total admin+keuangan gabungan —
     * dipakai untuk baris per-kasus & subtotal per-kampung (bukan baris TOTAL).
     *
     * @param  array{ssr: int, bsr: int, bd: int, jumlah: int}  $admin
     * @param  array{ssr: int, bsr: int, bd: int, jumlah: int}  $keuangan
     * @return array{admin: array{ssr:int,bsr:int,bd:int}, keuangan: array{ssr:int,bsr:int,bd:int}}
     */
    private function statusRatios(array $admin, array $keuangan): array
    {
        $total = $admin['jumlah'] + $keuangan['jumlah'];
        $pct = fn(int $v) => $total ? (int) round($v / $total * 100) : 0;

        return [
            'admin'    => ['ssr' => $pct($admin['ssr']), 'bsr' => $pct($admin['bsr']), 'bd' => $pct($admin['bd'])],
            'keuangan' => ['ssr' => $pct($keuangan['ssr']), 'bsr' => $pct($keuangan['bsr']), 'bd' => $pct($keuangan['bd'])],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyTotals(): array
    {
        return [
            'temuan'      => 0,
            'rekomendasi' => 0,
            'admin'       => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'keuangan'    => ['ssr' => 0, 'bsr' => 0, 'bd' => 0, 'jumlah' => 0],
            'bk'          => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'setoran'     => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
            'sisa'        => [1 => 0.0, 2 => 0.0, 3 => 0.0, 4 => 0.0],
        ];
    }

    /**
     * @param  array<string, mixed>  $totals
     * @param  array<string, mixed>  $kasusMetrics hasil dari RekapTnkAggregator::aggregate()
     * @return array<string, mixed>
     */
    private function addKasusMetrics(array $totals, array $kasusMetrics): array
    {
        $totals['temuan'] += $kasusMetrics['temuanCount'];
        $totals['rekomendasi'] += $kasusMetrics['rekomendasiCount'];

        foreach (['ssr', 'bsr', 'bd', 'jumlah'] as $k) {
            $totals['admin'][$k] += $kasusMetrics['admin'][$k];
            $totals['keuangan'][$k] += $kasusMetrics['keuangan'][$k];
        }

        foreach ([1, 2, 3, 4] as $n) {
            $totals['bk'][$n] += $kasusMetrics['bk'][$n];
            $totals['setoran'][$n] += $kasusMetrics['setoran'][$n];
            $totals['sisa'][$n] = max($totals['bk'][$n] - $totals['setoran'][$n], 0);
        }

        return $totals;
    }

    /**
     * @param  array<string, mixed>  $a
     * @param  array<string, mixed>  $b
     * @return array<string, mixed>
     */
    private function mergeTotals(array $a, array $b): array
    {
        $a['temuan'] += $b['temuan'];
        $a['rekomendasi'] += $b['rekomendasi'];

        foreach (['ssr', 'bsr', 'bd', 'jumlah'] as $k) {
            $a['admin'][$k] += $b['admin'][$k];
            $a['keuangan'][$k] += $b['keuangan'][$k];
        }

        foreach ([1, 2, 3, 4] as $n) {
            $a['bk'][$n] += $b['bk'][$n];
            $a['setoran'][$n] += $b['setoran'][$n];
            $a['sisa'][$n] = max($a['bk'][$n] - $a['setoran'][$n], 0);
        }

        return $a;
    }
}
