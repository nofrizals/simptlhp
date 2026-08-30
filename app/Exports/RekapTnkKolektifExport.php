<?php

declare(strict_types=1);

namespace App\Exports;

use App\Services\Rekap\RekapTnkKolektifReportBuilder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class RekapTnkKolektifExport implements FromArray, WithEvents, WithTitle
{
    public function __construct(
        private readonly int $idJenisPhp,
        private readonly string $tahunPemeriksaan,
        private readonly string $kodeUnor,
        private readonly RekapTnkKolektifReportBuilder $reportBuilder,
    ) {}

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Rekap TNK Kolektif';
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
        $report = $this->reportBuilder->build($this->idJenisPhp, $this->tahunPemeriksaan, $this->kodeUnor);
        $isTgr = $report['isTgr'];
        $lastCol = $isTgr ? 'O' : 'AC';

        $border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
        $bold = ['font' => ['bold' => true]];
        $alignMiddle = ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER];
        $alignTopLeft = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT];
        $alignRight = ['horizontal' => Alignment::HORIZONTAL_RIGHT];

        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $report['jenisPhpLabel'] . ' INSPEKTORAT DAERAH KABUPATEN SIAK');
        $sheet->mergeCells("A3:{$lastCol}3");
        $sheet->setCellValue('A3', $report['namaInstansiLabel']);
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
        $sheet->setCellValue('E5', 'TAHUN PEMERIKSAAN');
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

        $row = 8;

        foreach ($report['rows'] as $data) {
            $sheet->setCellValue('A' . $row, $data['no'] . '.');
            $sheet->setCellValue('B' . $row, $data['spt']);
            $sheet->setCellValue('C' . $row, $data['waktuPelaksanaan']);
            $sheet->setCellValue('D' . $row, $data['nomorLhp']);
            $sheet->setCellValue('E' . $row, $data['tahun']);
            $sheet->getStyle('B' . $row . ':D' . $row)->getAlignment()->applyFromArray($alignTopLeft);
            $sheet->getStyle('E' . $row)->getAlignment()->applyFromArray($alignMiddle);

            $sheet->setCellValue('F' . $row, $data['temuanCount']);
            $sheet->setCellValue('G' . $row, $data['rekomendasiCount']);

            if ($isTgr) {
                $sheet->setCellValue('H' . $row, $data['keuangan']['ssr']);
                $sheet->setCellValue('I' . $row, $data['keuangan']['bsr']);
                $sheet->setCellValue('J' . $row, $data['keuangan']['bd']);
                $sheet->setCellValue('K' . $row, $data['keuangan']['jumlah']);
                $sheet->setCellValue('L' . $row, $data['keuanganRatio'] / 100);
                $sheet->setCellValue('M' . $row, $data['bk'][2]);
                $sheet->setCellValue('N' . $row, $data['setoran'][2]);
                $sheet->setCellValue('O' . $row, $data['sisa'][2]);

                $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("M{$row}:O{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
            } else {
                $sheet->setCellValue('H' . $row, $data['admin']['ssr']);
                $sheet->setCellValue('I' . $row, $data['admin']['bsr']);
                $sheet->setCellValue('J' . $row, $data['admin']['bd']);
                $sheet->setCellValue('K' . $row, $data['admin']['jumlah']);
                $sheet->setCellValue('L' . $row, $data['adminRatio'] / 100);
                $sheet->setCellValue('M' . $row, $data['keuangan']['ssr']);
                $sheet->setCellValue('N' . $row, $data['keuangan']['bsr']);
                $sheet->setCellValue('O' . $row, $data['keuangan']['bd']);
                $sheet->setCellValue('P' . $row, $data['keuangan']['jumlah']);
                $sheet->setCellValue('Q' . $row, $data['keuanganRatio'] / 100);

                $sheet->setCellValue('R' . $row, $data['bk'][1]);
                $sheet->setCellValue('S' . $row, $data['setoran'][1]);
                $sheet->setCellValue('T' . $row, $data['sisa'][1]);

                $sheet->setCellValue('U' . $row, $data['bk'][2]);
                $sheet->setCellValue('V' . $row, $data['setoran'][2]);
                $sheet->setCellValue('W' . $row, $data['sisa'][2]);

                $sheet->setCellValue('X' . $row, $data['bk'][3]);
                $sheet->setCellValue('Y' . $row, $data['setoran'][3]);
                $sheet->setCellValue('Z' . $row, $data['sisa'][3]);

                $sheet->setCellValue('AA' . $row, $data['bk'][4]);
                $sheet->setCellValue('AB' . $row, $data['setoran'][4]);
                $sheet->setCellValue('AC' . $row, $data['sisa'][4]);

                $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("Q{$row}")->getNumberFormat()->setFormatCode('0%');
                $sheet->getStyle("R{$row}:AC{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
            }

            $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($border);
            $sheet->getStyle('F' . $row . ':' . $lastCol . $row)->getAlignment()->applyFromArray($alignRight);

            $row++;
        }

        // Baris JUMLAH
        $totals = $report['totals'];
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->setCellValue('A' . $row, 'JUMLAH');
        $sheet->setCellValue('F' . $row, $totals['temuan']);
        $sheet->setCellValue('G' . $row, $totals['rekomendasi']);

        if ($isTgr) {
            $sheet->setCellValue('H' . $row, $totals['keuangan']['ssr']);
            $sheet->setCellValue('I' . $row, $totals['keuangan']['bsr']);
            $sheet->setCellValue('J' . $row, $totals['keuangan']['bd']);
            $sheet->setCellValue('K' . $row, $totals['keuangan']['jumlah']);
            $sheet->setCellValue('L' . $row, $totals['keuanganRatio'] / 100);
            $sheet->setCellValue('M' . $row, $totals['bk'][2]);
            $sheet->setCellValue('N' . $row, $totals['setoran'][2]);
            $sheet->setCellValue('O' . $row, $totals['sisa'][2]);

            $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("M{$row}:O{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        } else {
            $sheet->setCellValue('H' . $row, $totals['admin']['ssr']);
            $sheet->setCellValue('I' . $row, $totals['admin']['bsr']);
            $sheet->setCellValue('J' . $row, $totals['admin']['bd']);
            $sheet->setCellValue('K' . $row, $totals['admin']['jumlah']);
            $sheet->setCellValue('L' . $row, $totals['adminRatio'] / 100);
            $sheet->setCellValue('M' . $row, $totals['keuangan']['ssr']);
            $sheet->setCellValue('N' . $row, $totals['keuangan']['bsr']);
            $sheet->setCellValue('O' . $row, $totals['keuangan']['bd']);
            $sheet->setCellValue('P' . $row, $totals['keuangan']['jumlah']);
            $sheet->setCellValue('Q' . $row, $totals['keuanganRatio'] / 100);

            $sheet->setCellValue('R' . $row, $totals['bk'][1]);
            $sheet->setCellValue('S' . $row, $totals['setoran'][1]);
            $sheet->setCellValue('T' . $row, $totals['sisa'][1]);
            $sheet->setCellValue('U' . $row, $totals['bk'][2]);
            $sheet->setCellValue('V' . $row, $totals['setoran'][2]);
            $sheet->setCellValue('W' . $row, $totals['sisa'][2]);
            $sheet->setCellValue('X' . $row, $totals['bk'][3]);
            $sheet->setCellValue('Y' . $row, $totals['setoran'][3]);
            $sheet->setCellValue('AA' . $row, $totals['sisa'][3]);
            $sheet->setCellValue('AB' . $row, $totals['bk'][4]);
            $sheet->setCellValue('AC' . $row, $totals['sisa'][4]);

            $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("Q{$row}")->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle("R{$row}:AC{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        }

        $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($border);
        $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($bold);
        $sheet->getStyle('F' . $row . ':' . $lastCol . $row)->getAlignment()->applyFromArray($alignRight);

        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        if (!$isTgr) {
            foreach (['AA', 'AB', 'AC'] as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // Footer tanda tangan
        $ttd = $report['ttd'];
        $footerRow = $row + 3;
        $ketTo = $isTgr ? 'L' : 'Q';
        $ttdCol = $isTgr ? 'J' : 'U';

        $sheet->mergeCells('F' . $footerRow . ':G' . $footerRow);
        $sheet->setCellValue('F' . $footerRow, 'Keterangan');
        $sheet->mergeCells($ttdCol . $footerRow . ':' . $lastCol . $footerRow);
        $sheet->setCellValue($ttdCol . $footerRow, 'SIAK SRI INDRAPURA, ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle($ttdCol . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'SSR');
        $sheet->mergeCells('G' . $footerRow . ':' . $ketTo . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Sudah Sesuai Rekomendasi (Selesai)');
        $sheet->mergeCells($ttdCol . $footerRow . ':' . $lastCol . $footerRow);
        $sheet->setCellValue($ttdCol . $footerRow, 'INSPEKTUR KABUPATEN SIAK');
        $sheet->getStyle($ttdCol . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'BSR');
        $sheet->mergeCells('G' . $footerRow . ':' . $ketTo . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Belum Sesuai Rekomendasi (Perlu Dilengkapi)');
        $footerRow++;

        $sheet->setCellValue('F' . $footerRow, 'BD');
        $sheet->mergeCells('G' . $footerRow . ':' . $ketTo . $footerRow);
        $sheet->setCellValue('G' . $footerRow, ': Belum ditindaklanjuti');
        $footerRow += 4;

        $sheet->mergeCells($ttdCol . $footerRow . ':' . $lastCol . $footerRow);
        $sheet->setCellValue($ttdCol . $footerRow, $ttd->nama_pegawai ?? '-');
        $sheet->getStyle($ttdCol . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->mergeCells($ttdCol . $footerRow . ':' . $lastCol . $footerRow);
        $sheet->setCellValue($ttdCol . $footerRow, 'NIP.' . ($ttd->id_pegawai ?? '-'));
        $sheet->getStyle($ttdCol . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
    }
}
