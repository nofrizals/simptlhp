<?php

declare(strict_types=1);

namespace App\Services\Rekap;

use App\Models\Kasus;
use App\Models\NilaiKerugian;
use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;
use Illuminate\Support\Collection;

final class RekapPhpReportBuilder
{
    public function __construct(
        private readonly RekapSignatureResolver $signatureResolver,
    ) {}

    /**
     * @return array{
     *     rows: array<int, array<string, mixed>>,
     *     totals: array{rincian: float, setor: float, sisa: float},
     *     ketuaTim: string|null,
     *     ttd: \App\Models\User|null,
     *     namaObrik: string,
     * }
     */
    public function build(Kasus $kasus): array
    {
        $kasus->loadMissing('instansi');

        $isTgr = (int) $kasus->id_jenis_php === 7;

        $temuanQuery = Temuan::query()
            ->active()
            ->where('id_kasus', $kasus->id_kasus);

        if ($isTgr) {
            $temuanQuery->where('besaran_kerugian2', '>', 0);
        }

        $temuans = $temuanQuery
            ->with([
                'rekomendasi' => fn($q) => $q->active()->orderBy('id_rekomendasi'),
                'rekomendasi.tindakLanjuts' => function ($q) use ($isTgr) {
                    $q->with(['status', 'createdBy', 'editedBy'])->orderBy('id_tindak_lanjut');

                    if ($isTgr) {
                        $q->where('rincian_keuangan2', '>', 0);
                    }
                },
            ])
            ->orderBy('id_temuan')
            ->get();

        [$rows, $totals] = $this->buildRows($temuans, $isTgr);

        return [
            'rows'      => $rows,
            'totals'    => $totals,
            'ketuaTim'  => $this->signatureResolver->getNamaPegawai($kasus->nip_ketua) ?? $kasus->nip_ketua,
            'ttd'       => $this->signatureResolver->getTtd(),
            'namaObrik' => $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor,
        ];
    }

    /**
     * @param  Collection<int, Temuan>  $temuans
     * @return array{0: array<int, array<string, mixed>>, 1: array{rincian: float, setor: float, sisa: float}}
     */
    private function buildRows(Collection $temuans, bool $isTgr): array
    {
        $rows = [];
        $no = 0;
        $penyebabTemp = null;
        $totals = ['rincian' => 0.0, 'setor' => 0.0, 'sisa' => 0.0];

        $nilaiKerugianMap = NilaiKerugian::query()->pluck('nilai_kerugian', 'id_nilai_kerugian');

        foreach ($temuans as $temuan) {
            $hasQualifyingTindakLanjut = $temuan->rekomendasi
                ->contains(fn(Rekomendasi $rekomendasi) => $rekomendasi->tindakLanjuts->isNotEmpty());

            if ($isTgr && ! $hasQualifyingTindakLanjut) {
                continue;
            }

            $no++;
            $isFirstRowOfTemuan = true;
            $nilaiKerugianHtml = $this->formatNilaiKerugian($temuan, $nilaiKerugianMap);

            $emitRow = function (?Rekomendasi $rekomendasi, ?Tindaklanjut $tindakLanjut) use (
                &$rows,
                &$isFirstRowOfTemuan,
                &$penyebabTemp,
                &$totals,
                $no,
                $temuan,
                $nilaiKerugianHtml
            ): void {
                $rincian = 0.0;
                $setor = 0.0;

                if ($tindakLanjut) {
                    $rincian = (float) $tindakLanjut->rincian_keuangan
                        + (float) $tindakLanjut->rincian_keuangan2
                        + (float) $tindakLanjut->rincian_keuangan3
                        + (float) $tindakLanjut->rincian_keuangan4;

                    $setor = (float) $tindakLanjut->setor
                        + (float) $tindakLanjut->setor2
                        + (float) $tindakLanjut->setor3
                        + (float) $tindakLanjut->setor4;
                }

                $sisa = $rincian - $setor;
                $totals['rincian'] += $rincian;
                $totals['setor'] += $setor;
                $totals['sisa'] += $sisa;

                $penyebab = $temuan->penyebab;
                if ($penyebab === $penyebabTemp) {
                    $penyebab = null;
                } else {
                    $penyebabTemp = $penyebab;
                }

                $rows[] = [
                    'temuan'            => $isFirstRowOfTemuan ? ($no . '. ' . $temuan->temuan) : null,
                    'nilai_kerugian'    => $isFirstRowOfTemuan ? $nilaiKerugianHtml : '',
                    'penyebab'          => $penyebab,
                    'rekomendasi'       => $rekomendasi?->rekomendasi,
                    'tindak_lanjut'     => $tindakLanjut?->tindak_lanjut,
                    'rincian'           => $rincian,
                    'setor'             => $setor,
                    'sisa'              => $sisa,
                    'status_tl'         => $tindakLanjut?->status?->status_tl,
                    'keterangan'        => $tindakLanjut?->keterangan,
                    'tgl_tindak_lanjut' => $tindakLanjut?->tgl_tindak_lanjut,
                    'created_by_nama'   => $tindakLanjut?->createdBy?->nama_pegawai,
                    'edited_by_nama'    => $tindakLanjut?->editedBy?->nama_pegawai,
                    'edited_at'         => $tindakLanjut?->edited_at,
                ];

                $isFirstRowOfTemuan = false;
            };

            if ($temuan->rekomendasi->isEmpty()) {
                $emitRow(null, null);

                continue;
            }

            foreach ($temuan->rekomendasi as $rekomendasi) {
                if ($rekomendasi->tindakLanjuts->isEmpty()) {
                    if ($isTgr) {
                        continue;
                    }

                    $emitRow($rekomendasi, null);

                    continue;
                }

                foreach ($rekomendasi->tindakLanjuts as $tindakLanjut) {
                    $emitRow($rekomendasi, $tindakLanjut);
                }
            }
        }

        return [$rows, $totals];
    }

    /**
     * @param  Collection<int|string, string>  $nilaiKerugianMap
     */
    private function formatNilaiKerugian(Temuan $temuan, Collection $nilaiKerugianMap): string
    {
        $parts = [];

        for ($i = 1; $i <= 4; $i++) {
            $suffix = $i === 1 ? '' : (string) $i;
            $idNilai = $temuan->{"id_nilai_kerugian{$suffix}"};

            if (! $idNilai) {
                continue;
            }

            $nama = $nilaiKerugianMap->get($idNilai);
            $besaran = number_format((float) $temuan->{"besaran_kerugian{$suffix}"}, 2, ',', '.');

            $parts[] = e($nama) . '<br><br>Rp' . $besaran;
        }

        return implode('', $parts);
    }
}
