<?php

declare(strict_types=1);

namespace App\Exports;

use App\Services\Rekap\RekapApbkamReportBuilder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class RekapApbkamExport implements FromArray, WithEvents, WithTitle
{
    private const LAST_COL = 'AI';

    public function __construct(
        private readonly string $tahunPemeriksaan,
        private readonly string $kodeUnor,
        private readonly RekapApbkamReportBuilder $reportBuilder,
    ) {}

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'APBKAM';
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
        $report = $this->reportBuilder->build($this->tahunPemeriksaan, $this->kodeUnor);
        $lastCol = self::LAST_COL;

        $border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
        $bold = ['font' => ['bold' => true]];
        $alignMiddle = ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER];
        $alignTopLeft = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT];
        $alignRight = ['horizontal' => Alignment::HORIZONTAL_RIGHT];
        $fmt = fn(float $v) => $v;

        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'TEMUAN HASIL PEMERIKSAAN APBKAM INSPEKTORAT KABUPATEN SIAK');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $this->tahunPemeriksaan !== 'semua'
            ? $report['kecamatanLabel'] . ' TAHUN ' . $this->tahunPemeriksaan
            : $report['kecamatanLabel']);
        $sheet->getStyle('A1:A2')->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle('A1:A2')->applyFromArray($bold);

        // Header
        $sheet->mergeCells('A4:B6');
        $sheet->setCellValue('A4', 'NO');
        $sheet->mergeCells('C4:C6');
        $sheet->setCellValue('C4', 'OBJEK PEMERIKSAAN');
        $sheet->mergeCells('D4:E4');
        $sheet->setCellValue('D4', 'JUMLAH');
        $sheet->mergeCells('D5:D6');
        $sheet->setCellValue('D5', 'TEMUAN');
        $sheet->mergeCells('E5:E6');
        $sheet->setCellValue('E5', 'REKOMENDASI');

        $sheet->mergeCells('F4:S4');
        $sheet->setCellValue('F4', 'TINDAK LANJUT');
        $sheet->mergeCells('F5:L5');
        $sheet->setCellValue('F5', 'ADMINISTRASI');
        $sheet->setCellValue('F6', 'SSR');
        $sheet->setCellValue('G6', '%');
        $sheet->setCellValue('H6', 'BSR');
        $sheet->setCellValue('I6', '%');
        $sheet->setCellValue('J6', 'BD');
        $sheet->setCellValue('K6', '%');
        $sheet->setCellValue('L6', 'JLH');
        $sheet->mergeCells('M5:S5');
        $sheet->setCellValue('M5', 'KEUANGAN');
        $sheet->setCellValue('M6', 'SSR');
        $sheet->setCellValue('N6', '%');
        $sheet->setCellValue('O6', 'BSR');
        $sheet->setCellValue('P6', '%');
        $sheet->setCellValue('Q6', 'BD');
        $sheet->setCellValue('R6', '%');
        $sheet->setCellValue('S6', 'JLH');

        $sheet->mergeCells('T4:W5');
        $sheet->setCellValue('T4', 'KEWAJIBAN STOR PAJAK(PPN & PPh)');
        $sheet->setCellValue('T6', 'NILAI (Rp)');
        $sheet->setCellValue('U6', 'DISETOR (Rp)');
        $sheet->setCellValue('V6', '%');
        $sheet->setCellValue('W6', 'SISA (Rp)');

        $sheet->mergeCells('X4:AA5');
        $sheet->setCellValue('X4', 'KEWAJIBAN SETOR KERUGIAN DAERAH');
        $sheet->setCellValue('X6', 'NILAI (Rp)');
        $sheet->setCellValue('Y6', 'DISETOR (Rp)');
        $sheet->setCellValue('Z6', '%');
        $sheet->setCellValue('AA6', 'SISA (Rp)');

        $sheet->mergeCells('AB4:AE5');
        $sheet->setCellValue('AB4', 'KEWAJIBAN SETOR KERUGIAN DESA');
        $sheet->setCellValue('AB6', 'NILAI (Rp)');
        $sheet->setCellValue('AC6', 'DISETOR (Rp)');
        $sheet->setCellValue('AD6', '%');
        $sheet->setCellValue('AE6', 'SISA (Rp)');

        $sheet->mergeCells('AF4:AI5');
        $sheet->setCellValue('AF4', 'KEWAJIBAN SETOR KERUGIAN BLUD');
        $sheet->setCellValue('AF6', 'NILAI (Rp)');
        $sheet->setCellValue('AG6', 'DISETOR (Rp)');
        $sheet->setCellValue('AH6', '%');
        $sheet->setCellValue('AI6', 'SISA (Rp)');

        $i = 0;
        foreach (range('A', 'Z') as $v) {
            $sheet->setCellValue($v . '7', (string) ++$i);
        }
        foreach (['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'] as $v) {
            $sheet->setCellValue($v . '7', (string) ++$i);
        }

        $sheet->getStyle("A4:{$lastCol}7")->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle("A4:{$lastCol}7")->applyFromArray($border);
        $sheet->getStyle("A4:{$lastCol}6")->applyFromArray($bold);

        $sheet->setCellValue('A8', '1.');
        $sheet->mergeCells("B8:{$lastCol}8");
        $sheet->setCellValue('B8', $report['kecamatanLabel']);

        $row = 9;

        foreach ($report['kampungRows'] as $kampungRow) {
            $sheet->setCellValue('B' . $row, $kampungRow['no'] . '.');
            $sheet->mergeCells('C' . $row . ':' . $lastCol . $row);
            $sheet->setCellValue('C' . $row, $kampungRow['namaKampung']);
            $rowAwal = $row + 1;
            $row++;

            foreach ($kampungRow['rows'] as $data) {
                $this->writeDataRow($sheet, $row, 'C' . $row, $data);
                $sheet->setCellValue('C' . $row, 'TP.' . $data['tahun']);
                $row++;
            }

            $rowAkhir = $row - 1;

            if ($rowAkhir >= $rowAwal) {
                $sheet->mergeCells('B' . $row . ':C' . $row);
                $sheet->setCellValue('B' . $row, 'JUMLAH');
                $this->writeTotalsRow($sheet, $row, $kampungRow['totals']);
                $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($bold);
            }

            $row++;
        }

        $sheet->mergeCells('A' . $row . ':' . $lastCol . $row);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F0F0');
        $row++;

        $sheet->mergeCells('A' . $row . ':C' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $this->writeTotalsRow($sheet, $row, $report['grandTotal']);
        $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($bold);

        $sheet->getStyle("A4:{$lastCol}{$row}")->getBorders()->applyFromArray($border);

        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach (['AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI'] as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row += 3;
        $ttd = $report['ttd'];

        $sheet->mergeCells('D' . $row . ':E' . $row);
        $sheet->setCellValue('D' . $row, 'Keterangan');
        $sheet->mergeCells('X' . $row . ':AA' . $row);
        $sheet->setCellValue('X' . $row, 'SIAK SRI INDRAPURA, ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle('X' . $row)->getAlignment()->applyFromArray($alignTopLeft);
        $row++;

        $sheet->setCellValue('D' . $row, 'SSR');
        $sheet->mergeCells('E' . $row . ':L' . $row);
        $sheet->setCellValue('E' . $row, ': Sudah Sesuai Rekomendasi (Selesai)');
        $sheet->mergeCells('X' . $row . ':AA' . $row);
        $sheet->setCellValue('X' . $row, 'INSPEKTUR KABUPATEN SIAK');
        $sheet->getStyle('X' . $row)->getAlignment()->applyFromArray($alignTopLeft);
        $row++;

        $sheet->setCellValue('D' . $row, 'BSR');
        $sheet->mergeCells('E' . $row . ':L' . $row);
        $sheet->setCellValue('E' . $row, ': Belum Sesuai Rekomendasi (Perlu Dilengkapi)');
        $row++;

        $sheet->setCellValue('D' . $row, 'BD');
        $sheet->mergeCells('E' . $row . ':L' . $row);
        $sheet->setCellValue('E' . $row, ': Belum Ditindaklanjuti');
        $row += 4;

        $sheet->mergeCells('X' . $row . ':AA' . $row);
        $sheet->setCellValue('X' . $row, $ttd->nama_pegawai ?? '-');
        $sheet->getStyle('X' . $row)->getAlignment()->applyFromArray($alignTopLeft);
        $row++;

        $sheet->mergeCells('X' . $row . ':AA' . $row);
        $sheet->setCellValue('X' . $row, 'NIP.' . ($ttd->id_pegawai ?? '-'));
        $sheet->getStyle('X' . $row)->getAlignment()->applyFromArray($alignTopLeft);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function writeDataRow(Worksheet $sheet, int $row, string $ignored, array $data): void
    {
        $sheet->setCellValue('D' . $row, $data['temuanCount']);
        $sheet->setCellValue('E' . $row, $data['rekomendasiCount']);

        $sheet->setCellValue('F' . $row, $data['admin']['ssr']);
        $sheet->setCellValue('G' . $row, $data['ratios']['admin']['ssr'] / 100);
        $sheet->setCellValue('H' . $row, $data['admin']['bsr']);
        $sheet->setCellValue('I' . $row, $data['ratios']['admin']['bsr'] / 100);
        $sheet->setCellValue('J' . $row, $data['admin']['bd']);
        $sheet->setCellValue('K' . $row, $data['ratios']['admin']['bd'] / 100);
        $sheet->setCellValue('L' . $row, $data['admin']['jumlah']);

        $sheet->setCellValue('M' . $row, $data['keuangan']['ssr']);
        $sheet->setCellValue('N' . $row, $data['ratios']['keuangan']['ssr'] / 100);
        $sheet->setCellValue('O' . $row, $data['keuangan']['bsr']);
        $sheet->setCellValue('P' . $row, $data['ratios']['keuangan']['bsr'] / 100);
        $sheet->setCellValue('Q' . $row, $data['keuangan']['bd']);
        $sheet->setCellValue('R' . $row, $data['ratios']['keuangan']['bd'] / 100);
        $sheet->setCellValue('S' . $row, $data['keuangan']['jumlah']);

        $sheet->setCellValue('T' . $row, $data['bk'][1]);
        $sheet->setCellValue('U' . $row, $data['setoran'][1]);
        $sheet->setCellValue('V' . $row, $data['bk'][1] > 0 ? $data['setoran'][1] / $data['bk'][1] : 0);
        $sheet->setCellValue('W' . $row, $data['sisa'][1]);

        $sheet->setCellValue('X' . $row, $data['bk'][2]);
        $sheet->setCellValue('Y' . $row, $data['setoran'][2]);
        $sheet->setCellValue('Z' . $row, $data['bk'][2] > 0 ? $data['setoran'][2] / $data['bk'][2] : 0);
        $sheet->setCellValue('AA' . $row, $data['sisa'][2]);

        $sheet->setCellValue('AB' . $row, $data['bk'][3]);
        $sheet->setCellValue('AC' . $row, $data['setoran'][3]);
        $sheet->setCellValue('AD' . $row, $data['bk'][3] > 0 ? $data['setoran'][3] / $data['bk'][3] : 0);
        $sheet->setCellValue('AE' . $row, $data['sisa'][3]);

        $sheet->setCellValue('AF' . $row, $data['bk'][4]);
        $sheet->setCellValue('AG' . $row, $data['setoran'][4]);
        $sheet->setCellValue('AH' . $row, $data['bk'][4] > 0 ? $data['setoran'][4] / $data['bk'][4] : 0);
        $sheet->setCellValue('AI' . $row, $data['sisa'][4]);

        $sheet->getStyle("G{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("I{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("K{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("N{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("P{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("R{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("V{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("Z{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("AD{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("AH{$row}")->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle("T{$row}:AI{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('D' . $row . ':' . self::LAST_COL . $row)->getAlignment()->applyFromArray(['horizontal' => Alignment::HORIZONTAL_CENTER]);
    }

    /**
     * @param  array<string, mixed>  $totals
     */
    private function writeTotalsRow(Worksheet $sheet, int $row, array $totals): void
    {
        $this->writeDataRow($sheet, $row, '', [
            'temuanCount'      => $totals['temuan'],
            'rekomendasiCount' => $totals['rekomendasi'],
            'admin'            => $totals['admin'],
            'keuangan'         => $totals['keuangan'],
            'ratios'           => $totals['ratios'],
            'bk'               => $totals['bk'],
            'setoran'          => $totals['setoran'],
            'sisa'             => $totals['sisa'],
        ]);
    }
}
