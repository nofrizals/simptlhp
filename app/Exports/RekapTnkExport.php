<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Kasus;
use App\Services\Rekap\RekapTnkReportBuilder;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class RekapTnkExport implements FromArray, WithEvents, WithTitle
{
    public function __construct(
        private readonly Kasus $kasus,
        private readonly RekapTnkReportBuilder $reportBuilder,
    ) {}

    /**
     * Sumber data "kosong" — seluruh isi sheet ditulis manual lewat event AfterSheet
     * di bawah, supaya bisa replikasi merge cell/border/format persis seperti versi CI.
     */
    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Rekap TNK';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $this->fill($event->sheet->getDelegate());
            },
        ];
    }

    private function fill(Worksheet $sheet): void
    {
        $report = $this->reportBuilder->build($this->kasus);
        $isTgr = $report['isTgr'];
        $lastCol = $isTgr ? 'T' : 'AC';

        $border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
        $bold = ['font' => ['bold' => true]];
        $alignMiddle = ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER];
        $alignTopLeft = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT];
        $alignRight = ['horizontal' => Alignment::HORIZONTAL_RIGHT];

        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $this->kasus->jenis_php?->jenis_php . ' INSPEKTORAT DAERAH KABUPATEN SIAK');
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->setCellValue('A3', 'TAHUN PHP : ' . strtoupper((string) $this->kasus->tahun_pemeriksaan));
        $sheet->getStyle('A1:A3')->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle('A1:A3')->applyFromArray($bold);

        // Header tabel
        $sheet->mergeCells('A5:A7');
        $sheet->setCellValue('A5', 'NO');
        $sheet->mergeCells('B5:B7');
        $sheet->setCellValue('B5', 'NO. & TGL SURAT TUGAS');
        $sheet->mergeCells('C5:C7');
        $sheet->setCellValue('C5', 'WAKTU PELAKSANAAN');
        $sheet->mergeCells('D5:D7');
        $sheet->setCellValue('D5', 'NOMOR LHP');
        $sheet->mergeCells('E5:E7');
        $sheet->setCellValue('E5', 'OBJEK PEMERIKSAAN');
        $sheet->mergeCells('F5:G5');
        $sheet->setCellValue('F5', 'JUMLAH');
        $sheet->mergeCells('F6:F7');
        $sheet->setCellValue('F6', 'TEMUAN');
        $sheet->mergeCells('G6:G7');
        $sheet->setCellValue('G6', 'REKOMENDASI');

        if ($isTgr) {
            $sheet->mergeCells('H5:L5');
            $sheet->setCellValue('H5', 'TINDAK LANJUT');
            $sheet->mergeCells('H6:L6');
            $sheet->setCellValue('H6', 'KEUANGAN');
            $sheet->setCellValue('H7', 'SSR');
            $sheet->setCellValue('I7', 'BSR');
            $sheet->setCellValue('J7', 'BD');
            $sheet->setCellValue('K7', 'JUM');
            $sheet->setCellValue('L7', '%');
            $sheet->mergeCells('M5:O6');
            $sheet->setCellValue('M5', 'KEWAJIBAN SETOR KERUGIAN DAERAH');
            $sheet->setCellValue('M7', 'NILAI (Rp)');
            $sheet->setCellValue('N7', 'DISETOR (Rp)');
            $sheet->setCellValue('O7', 'SISA (Rp)');
        } else {
            $sheet->mergeCells('H5:Q5');
            $sheet->setCellValue('H5', 'TINDAK LANJUT');
            $sheet->mergeCells('H6:L6');
            $sheet->setCellValue('H6', 'ADMINISTRASI');
            $sheet->mergeCells('M6:Q6');
            $sheet->setCellValue('M6', 'KEUANGAN');
            $sheet->setCellValue('H7', 'SSR');
            $sheet->setCellValue('I7', 'BSR');
            $sheet->setCellValue('J7', 'BD');
            $sheet->setCellValue('K7', 'JUM');
            $sheet->setCellValue('L7', '%');
            $sheet->setCellValue('M7', 'SSR');
            $sheet->setCellValue('N7', 'BSR');
            $sheet->setCellValue('O7', 'BD');
            $sheet->setCellValue('P7', 'JUM');
            $sheet->setCellValue('Q7', '%');

            $sheet->mergeCells('R5:T6');
            $sheet->setCellValue('R5', 'KEWAJIBAN STOR PAJAK(PPN & PPh)');
            $sheet->setCellValue('R7', 'NILAI (Rp)');
            $sheet->setCellValue('S7', 'DISETOR (Rp)');
            $sheet->setCellValue('T7', 'SISA (Rp)');

            $sheet->mergeCells('U5:W6');
            $sheet->setCellValue('U5', 'KEWAJIBAN SETOR KERUGIAN DAERAH');
            $sheet->setCellValue('U7', 'NILAI (Rp)');
            $sheet->setCellValue('V7', 'DISETOR (Rp)');
            $sheet->setCellValue('W7', 'SISA (Rp)');

            $sheet->mergeCells('X5:Z6');
            $sheet->setCellValue('X5', 'KEWAJIBAN SETOR KERUGIAN DESA');
            $sheet->setCellValue('X7', 'NILAI (Rp)');
            $sheet->setCellValue('Y7', 'DISETOR (Rp)');
            $sheet->setCellValue('Z7', 'SISA (Rp)');

            $sheet->mergeCells('AA5:AC6');
            $sheet->setCellValue('AA5', 'KEWAJIBAN SETOR KERUGIAN BLUD');
            $sheet->setCellValue('AA7', 'NILAI (Rp)');
            $sheet->setCellValue('AB7', 'DISETOR (Rp)');
            $sheet->setCellValue('AC7', 'SISA (Rp)');
        }

        $sheet->getStyle("A5:{$lastCol}7")->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle("A5:{$lastCol}7")->applyFromArray($border);
        $sheet->getStyle("A5:{$lastCol}7")->applyFromArray($bold);

        // Baris data (1 baris agregat untuk kasus ini) + baris JUMLAH (identik)
        $namaObrik = $report['namaObrik'];
        $waktu = '';
        if ($this->kasus->spt_mulai) {
            $waktu = Carbon::parse($this->kasus->spt_mulai)->translatedFormat('d M Y')
                . ' ~ ' . Carbon::parse($this->kasus->spt_selesai)->translatedFormat('d M Y');
        }

        foreach ([8, 9] as $index => $row) {
            $isJumlahRow = $index === 1;

            if ($isJumlahRow) {
                $sheet->mergeCells('A' . $row . ':E' . $row);
                $sheet->setCellValue('A' . $row, 'JUMLAH');
            } else {
                $sheet->setCellValue('A' . $row, '1.');
                $sheet->setCellValue('B' . $row, $this->kasus->spt);
                $sheet->setCellValue('C' . $row, $waktu);
                $sheet->setCellValue('D' . $row, $this->kasus->nomor_lhp);
                $sheet->setCellValue('E' . $row, $namaObrik);
            }

            $sheet->setCellValue('F' . $row, $report['temuanCount']);
            $sheet->setCellValue('G' . $row, $report['rekomendasiCount']);

            if ($isTgr) {
                $sheet->setCellValue('H' . $row, $report['keuangan']['ssr']);
                $sheet->setCellValue('I' . $row, $report['keuangan']['bsr']);
                $sheet->setCellValue('J' . $row, $report['keuangan']['bd']);
                $sheet->setCellValue('K' . $row, $report['keuangan']['jumlah']);
                $sheet->setCellValue('L' . $row, $report['keuanganRatio'] / 100);
                $sheet->setCellValue('M' . $row, $report['bk'][2]);
                $sheet->setCellValue('N' . $row, $report['setoran'][2]);
                $sheet->setCellValue('O' . $row, max($report['bk'][2] - $report['setoran'][2], 0));

                $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("M{$row}:O{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
            } else {
                $sheet->setCellValue('H' . $row, $report['admin']['ssr']);
                $sheet->setCellValue('I' . $row, $report['admin']['bsr']);
                $sheet->setCellValue('J' . $row, $report['admin']['bd']);
                $sheet->setCellValue('K' . $row, $report['admin']['jumlah']);
                $sheet->setCellValue('L' . $row, $report['adminRatio'] / 100);
                $sheet->setCellValue('M' . $row, $report['keuangan']['ssr']);
                $sheet->setCellValue('N' . $row, $report['keuangan']['bsr']);
                $sheet->setCellValue('O' . $row, $report['keuangan']['bd']);
                $sheet->setCellValue('P' . $row, $report['keuangan']['jumlah']);
                $sheet->setCellValue('Q' . $row, $report['keuanganRatio'] / 100);

                $sheet->setCellValue('R' . $row, $report['bk'][1]);
                $sheet->setCellValue('S' . $row, $report['setoran'][1]);
                $sheet->setCellValue('T' . $row, max($report['bk'][1] - $report['setoran'][1], 0));

                $sheet->setCellValue('U' . $row, $report['bk'][2]);
                $sheet->setCellValue('V' . $row, $report['setoran'][2]);
                $sheet->setCellValue('W' . $row, max($report['bk'][2] - $report['setoran'][2], 0));

                $sheet->setCellValue('X' . $row, $report['bk'][3]);
                $sheet->setCellValue('Y' . $row, $report['setoran'][3]);
                $sheet->setCellValue('Z' . $row, max($report['bk'][3] - $report['setoran'][3], 0));

                $sheet->setCellValue('AA' . $row, $report['bk'][4]);
                $sheet->setCellValue('AB' . $row, $report['setoran'][4]);
                $sheet->setCellValue('AC' . $row, max($report['bk'][4] - $report['setoran'][4], 0));

                $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("Q{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("R{$row}:AC{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
            }

            $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($border);
            $sheet->getStyle('F' . $row . ':' . $lastCol . $row)->getAlignment()->applyFromArray($alignRight);

            if ($isJumlahRow) {
                $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($bold);
            }
        }

        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        if (! $isTgr) {
            foreach (['AA', 'AB', 'AC'] as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        $ttd = $report['ttd'];
        $footerRow = 12;

        $sheet->mergeCells('F' . $footerRow . ':G' . $footerRow);
        $sheet->setCellValue('F' . $footerRow, 'Keterangan');
        $sheet->mergeCells('V' . $footerRow . ':X' . $footerRow);
        $sheet->setCellValue('V' . $footerRow, 'SIAK SRI INDRAPURA, ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle('V' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'SSR');
        $sheet->mergeCells('G' . $footerRow . ':Q' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Sudah Sesuai Rekomendasi (Selesai)');
        $sheet->mergeCells('V' . $footerRow . ':X' . $footerRow);
        $sheet->setCellValue('V' . $footerRow, 'INSPEKTUR KABUPATEN SIAK');
        $sheet->getStyle('V' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'BSR');
        $sheet->mergeCells('G' . $footerRow . ':Q' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Belum Sesuai Rekomendasi (Perlu Dilengkapi)');
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'BD');
        $sheet->mergeCells('G' . $footerRow . ':Q' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Belum ditindaklanjuti');
        $footerRow += 4;

        $sheet->mergeCells('V' . $footerRow . ':X' . $footerRow);
        $sheet->setCellValue('V' . $footerRow, $ttd->nama_pegawai ?? '-');
        $sheet->getStyle('V' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->mergeCells('V' . $footerRow . ':X' . $footerRow);
        $sheet->setCellValue('V' . $footerRow, 'NIP.' . ($ttd->id_pegawai ?? '-'));
        $sheet->getStyle('V' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
    }
}
