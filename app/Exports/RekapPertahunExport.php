<?php

declare(strict_types=1);

namespace App\Exports;

use App\Services\Rekap\RekapPertahunReportBuilder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class RekapPertahunExport implements FromArray, WithEvents, WithTitle
{
    private const LAST_COL = 'AD';

    public function __construct(
        private readonly int $idJenisPhp,
        private readonly RekapPertahunReportBuilder $reportBuilder,
    ) {}

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Rekap Pertahun';
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
        $report = $this->reportBuilder->build($this->idJenisPhp);
        $lastCol = self::LAST_COL;

        $border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
        $bold = ['font' => ['bold' => true]];
        $alignMiddle = ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER];
        $alignTopLeft = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT];
        $alignRight = ['horizontal' => Alignment::HORIZONTAL_RIGHT];

        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'REKAPITULASI TEMUAN HASIL PEMERIKSAAN INSPEKTORAT KABUPATEN SIAK');
        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $report['subJudul']);
        $sheet->getStyle('A1:A2')->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle('A1:A2')->applyFromArray($bold);

        $sheet->setCellValue('A4', 'NO.');
        $sheet->mergeCells('A4:A6');
        $sheet->setCellValue('B4', 'TAHUN');
        $sheet->mergeCells('B4:B6');
        $sheet->setCellValue('C4', 'JUMLAH');
        $sheet->mergeCells('C4:D4');
        $sheet->setCellValue('C5', 'TEMUAN');
        $sheet->mergeCells('C5:C6');
        $sheet->setCellValue('D5', 'REKOMENDASI');
        $sheet->mergeCells('D5:D6');

        $sheet->setCellValue('E4', 'TINDAK LANJUT');
        $sheet->mergeCells('E4:R4');

        $sheet->setCellValue('E5', 'ADM');
        $sheet->mergeCells('E5:K5');
        $sheet->setCellValue('E6', 'SSR');
        $sheet->setCellValue('F6', '%');
        $sheet->setCellValue('G6', 'BSR');
        $sheet->setCellValue('H6', '%');
        $sheet->setCellValue('I6', 'BD');
        $sheet->setCellValue('J6', '%');
        $sheet->setCellValue('K6', 'JML');

        $sheet->setCellValue('L5', 'KEUANGAN');
        $sheet->mergeCells('L5:R5');
        $sheet->setCellValue('L6', 'SSR');
        $sheet->setCellValue('M6', '%');
        $sheet->setCellValue('N6', 'BSR');
        $sheet->setCellValue('O6', '%');
        $sheet->setCellValue('P6', 'BD');
        $sheet->setCellValue('Q6', '%');
        $sheet->setCellValue('R6', 'JML');

        $sheet->setCellValue('S4', 'KEWAJIBAN STOR PAJAK(PPN & PPh)');
        $sheet->mergeCells('S4:U5');
        $sheet->setCellValue('S6', 'NILAI (Rp)');
        $sheet->setCellValue('T6', 'DISETOR (Rp)');
        $sheet->setCellValue('U6', 'SISA (Rp)');

        $sheet->setCellValue('V4', 'KEWAJIBAN SETOR KERUGIAN DAERAH');
        $sheet->mergeCells('V4:X5');
        $sheet->setCellValue('V6', 'NILAI (Rp)');
        $sheet->setCellValue('W6', 'DISETOR (Rp)');
        $sheet->setCellValue('X6', 'SISA (Rp)');

        $sheet->setCellValue('Y4', 'KEWAJIBAN SETOR KERUGIAN DESA');
        $sheet->mergeCells('Y4:AA5');
        $sheet->setCellValue('Y6', 'NILAI (Rp)');
        $sheet->setCellValue('Z6', 'DISETOR (Rp)');
        $sheet->setCellValue('AA6', 'SISA (Rp)');

        $sheet->setCellValue('AB4', 'KEWAJIBAN SETOR KERUGIAN BLUD');
        $sheet->mergeCells('AB4:AD5');
        $sheet->setCellValue('AB6', 'NILAI (Rp)');
        $sheet->setCellValue('AC6', 'DISETOR (Rp)');
        $sheet->setCellValue('AD6', 'SISA (Rp)');

        $i = 0;
        foreach (range('A', 'Z') as $v) {
            $sheet->setCellValue($v . '7', (string) ++$i);
        }
        foreach (['AA', 'AB', 'AC', 'AD'] as $v) {
            $sheet->setCellValue($v . '7', (string) ++$i);
        }

        $sheet->getStyle("A4:{$lastCol}7")->getBorders()->applyFromArray($border);
        $sheet->getStyle("A4:{$lastCol}7")->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle("A4:{$lastCol}6")->applyFromArray($bold);

        $row = 8;

        foreach ($report['rows'] as $data) {
            $this->writeDataRow($sheet, $row, $data['tahun'], $data);
            $row++;
        }

        $lastDataRow = $row - 1;
        $totals = $report['totals'];

        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('A' . $row, 'JUMLAH');
        $this->writeDataRow($sheet, $row, null, $totals);
        $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->applyFromArray($bold);

        $sheet->getStyle("A4:{$lastCol}{$row}")->getBorders()->applyFromArray($border);

        foreach (range('A', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        foreach (['AA', 'AB', 'AC', 'AD'] as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $barisKet = $row + 3;
        $ttd = $report['ttd'];

        $sheet->mergeCells('B' . $barisKet . ':H' . $barisKet);
        $sheet->setCellValue('B' . $barisKet, 'Keterangan');
        $sheet->mergeCells('AA' . $barisKet . ':AC' . $barisKet);
        $sheet->setCellValue('AA' . $barisKet, 'SIAK SRI INDRAPURA, ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle('AA' . $barisKet)->getAlignment()->applyFromArray($alignTopLeft);
        $barisKet++;

        $sheet->mergeCells('B' . $barisKet . ':H' . $barisKet);
        $sheet->setCellValue('B' . $barisKet, 'SSR : Sudah Sesuai Rekomendasi (Selesai)');
        $sheet->mergeCells('AA' . $barisKet . ':AC' . $barisKet);
        $sheet->setCellValue('AA' . $barisKet, 'INSPEKTUR KABUPATEN SIAK');
        $sheet->getStyle('AA' . $barisKet)->getAlignment()->applyFromArray($alignTopLeft);
        $barisKet++;

        $sheet->mergeCells('B' . $barisKet . ':H' . $barisKet);
        $sheet->setCellValue('B' . $barisKet, 'BSR : Belum Sesuai Rekomendasi (Perlu Dilengkapi)');
        $barisKet++;

        $sheet->mergeCells('B' . $barisKet . ':H' . $barisKet);
        $sheet->setCellValue('B' . $barisKet, 'BD : Belum ditindaklanjuti');
        $barisKet += 4;

        $sheet->mergeCells('AA' . $barisKet . ':AC' . $barisKet);
        $sheet->setCellValue('AA' . $barisKet, $ttd->nama_pegawai ?? '-');
        $sheet->getStyle('AA' . $barisKet)->getAlignment()->applyFromArray($alignTopLeft);
        $barisKet++;

        $sheet->mergeCells('AA' . $barisKet . ':AC' . $barisKet);
        $sheet->setCellValue('AA' . $barisKet, 'NIP : ' . ($ttd->id_pegawai ?? '-'));
        $sheet->getStyle('AA' . $barisKet)->getAlignment()->applyFromArray($alignTopLeft);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function writeDataRow(Worksheet $sheet, int $row, ?string $tahun, array $data): void
    {
        if ($tahun !== null) {
            $sheet->setCellValue('B' . $row, $tahun);
        }

        $sheet->setCellValue('C' . $row, $data['temuan'] ?? $data['temuanCount']);
        $sheet->setCellValue('D' . $row, $data['rekomendasi'] ?? $data['rekomendasiCount']);

        $adminRatios = $data['adminRatios'];
        $keuanganRatios = $data['keuanganRatios'];

        $sheet->setCellValue('E' . $row, $data['admin']['ssr']);
        $sheet->setCellValue('F' . $row, $adminRatios['ssr'] / 100);
        $sheet->setCellValue('G' . $row, $data['admin']['bsr']);
        $sheet->setCellValue('H' . $row, $adminRatios['bsr'] / 100);
        $sheet->setCellValue('I' . $row, $data['admin']['bd']);
        $sheet->setCellValue('J' . $row, $adminRatios['bd'] / 100);
        $sheet->setCellValue('K' . $row, $data['admin']['jumlah']);

        $sheet->setCellValue('L' . $row, $data['keuangan']['ssr']);
        $sheet->setCellValue('M' . $row, $keuanganRatios['ssr'] / 100);
        $sheet->setCellValue('N' . $row, $data['keuangan']['bsr']);
        $sheet->setCellValue('O' . $row, $keuanganRatios['bsr'] / 100);
        $sheet->setCellValue('P' . $row, $data['keuangan']['bd']);
        $sheet->setCellValue('Q' . $row, $keuanganRatios['bd'] / 100);
        $sheet->setCellValue('R' . $row, $data['keuangan']['jumlah']);

        $sheet->setCellValue('S' . $row, $data['bk'][1]);
        $sheet->setCellValue('T' . $row, $data['setoran'][1]);
        $sheet->setCellValue('U' . $row, $data['sisa'][1]);

        $sheet->setCellValue('V' . $row, $data['bk'][2]);
        $sheet->setCellValue('W' . $row, $data['setoran'][2]);
        $sheet->setCellValue('X' . $row, $data['sisa'][2]);

        $sheet->setCellValue('Y' . $row, $data['bk'][3]);
        $sheet->setCellValue('Z' . $row, $data['setoran'][3]);
        $sheet->setCellValue('AA' . $row, $data['sisa'][3]);

        $sheet->setCellValue('AB' . $row, $data['bk'][4]);
        $sheet->setCellValue('AC' . $row, $data['setoran'][4]);
        $sheet->setCellValue('AD' . $row, $data['sisa'][4]);

        foreach (['F', 'H', 'J', 'M', 'O', 'Q'] as $col) {
            $sheet->getStyle("{$col}{$row}")->getNumberFormat()->setFormatCode('0%');
        }
        $sheet->getStyle("S{$row}:AD{$row}")->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle("S{$row}:AD{$row}")->getAlignment()->applyFromArray(['horizontal' => Alignment::HORIZONTAL_RIGHT]);
        $sheet->getStyle("C{$row}:R{$row}")->getAlignment()->applyFromArray(['horizontal' => Alignment::HORIZONTAL_CENTER]);
    }
}
