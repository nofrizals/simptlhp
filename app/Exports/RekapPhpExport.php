<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Kasus;
use App\Services\Rekap\RekapPhpReportBuilder;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

final class RekapPhpExport implements FromArray, WithEvents, WithTitle
{
    public function __construct(
        private readonly Kasus $kasus,
        private readonly RekapPhpReportBuilder $reportBuilder,
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
        return 'Rekap PHP';
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
        $rows = $report['rows'];
        $totals = $report['totals'];
        $namaObrik = $report['namaObrik'];

        $border = ['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]];
        $bold = ['font' => ['bold' => true]];
        $alignMiddle = ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER];
        $alignTopLeft = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_LEFT];
        $alignTopRight = ['vertical' => Alignment::VERTICAL_TOP, 'horizontal' => Alignment::HORIZONTAL_RIGHT];

        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'MATRIK TINDAK LANJUT HASIL PEMERIKSAAN INSPEKTORAT DAERAH KABUPATEN SIAK');
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', 'PADA ' . strtoupper($namaObrik));
        $sheet->getStyle('A1:A2')->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle('A1:A2')->applyFromArray($bold);

        $waktu = '';
        if ($this->kasus->spt_mulai) {
            $waktu = Carbon::parse($this->kasus->spt_mulai)->translatedFormat('d M Y')
                . ' s.d ' . Carbon::parse($this->kasus->spt_selesai)->translatedFormat('d M Y');
        }

        $sheet->setCellValue('A5', 'NO. & TGL SURAT TUGAS');
        $sheet->setCellValue('B5', ': ' . strtoupper((string) $this->kasus->spt));
        $sheet->setCellValue('A6', 'WAKTU PEMERIKSAAN');
        $sheet->setCellValue('B6', ': ' . strtoupper($waktu));
        $sheet->setCellValue('A7', 'NOMOR LHP');
        $sheet->setCellValue('B7', ': ' . strtoupper((string) $this->kasus->nomor_lhp));
        $sheet->setCellValue('A8', 'TANGGAL LHP');
        $sheet->setCellValue('B8', ': ' . ($this->kasus->tanggal_lhp
            ? strtoupper(Carbon::parse($this->kasus->tanggal_lhp)->translatedFormat('d F Y'))
            : ''));
        $sheet->setCellValue('A9', 'NAMA OBRIK');
        $sheet->setCellValue('B9', ': ' . strtoupper($namaObrik));
        $sheet->getStyle('A5:A9')->applyFromArray($bold);

        $headers = [
            'A11' => 'TEMUAN',
            'B11' => 'NILAI KERUGIAN',
            'C11' => 'PENYEBAB',
            'D11' => 'REKOMENDASI',
            'E11' => 'TINDAK LANJUT',
            'F11' => 'TEMUAN KEUANGAN',
            'G11' => 'STOR',
            'H11' => 'SISA SETOR',
            'I11' => 'STATUS',
            'J11' => 'KETERANGAN',
            'K11' => 'TGL TINDAK LANJUT',
        ];
        foreach ($headers as $cell => $label) {
            $sheet->setCellValue($cell, $label);
        }
        $sheet->getStyle('A11:K11')->applyFromArray($bold);
        $sheet->getStyle('A11:K11')->getAlignment()->applyFromArray($alignMiddle);
        $sheet->getStyle('A11:K11')->applyFromArray($border);

        $row = 12;

        foreach ($rows as $data) {
            $nilaiKerugianText = trim(str_replace(
                ['<br><br>', '<br>'],
                ["\n", "\n"],
                (string) $data['nilai_kerugian']
            ));

            $tglTindakLanjut = $data['tgl_tindak_lanjut']
                ? Carbon::parse($data['tgl_tindak_lanjut'])->translatedFormat('d F Y')
                : '-';

            $keteranganTl = 'Petugas entry : ' . ($data['created_by_nama'] ?? '-');
            if (! empty($data['edited_by_nama'])) {
                $keteranganTl .= "\nTelah diedit oleh " . $data['edited_by_nama']
                    . ' pada tanggal ' . Carbon::parse($data['edited_at'])->translatedFormat('d F Y');
            }

            $sheet->setCellValue('A' . $row, $data['temuan']);
            $sheet->setCellValue('B' . $row, $nilaiKerugianText);
            $sheet->setCellValue('C' . $row, $data['penyebab']);
            $sheet->setCellValue('D' . $row, $data['rekomendasi']);
            $sheet->setCellValue('E' . $row, $data['tindak_lanjut']);
            $sheet->setCellValue('F' . $row, $data['rincian']);
            $sheet->setCellValue('G' . $row, $data['setor']);
            $sheet->setCellValue('H' . $row, $data['sisa']);
            $sheet->setCellValue('I' . $row, $data['status_tl']);
            $sheet->setCellValue('J' . $row, $data['keterangan']);
            $sheet->setCellValue('K' . $row, $tglTindakLanjut . "\n" . $keteranganTl);

            $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray($border);
            $sheet->getStyle('A' . $row . ':E' . $row)->getAlignment()->applyFromArray($alignTopLeft)->setWrapText(true);
            $sheet->getStyle('F' . $row . ':H' . $row)->getAlignment()->applyFromArray($alignTopRight);
            $sheet->getStyle('J' . $row . ':K' . $row)->getAlignment()->applyFromArray($alignTopLeft)->setWrapText(true);
            $sheet->getStyle('F' . $row . ':H' . $row)
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

            $row++;
        }

        $lastDataRow = $row - 1;

        $sheet->setCellValue('F' . $row, $totals['rincian']);
        $sheet->setCellValue('G' . $row, $totals['setor']);
        $sheet->setCellValue('H' . $row, $totals['sisa']);
        $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray($border)->applyFromArray($bold);
        $sheet->getStyle('F' . $row . ':H' . $row)->getAlignment()->applyFromArray($alignTopRight);
        $sheet->getStyle('F' . $row . ':H' . $row)->getNumberFormat()->setFormatCode('#,##0.00');

        $sheet->getStyle('A11:J' . $row)->getAlignment()->setWrapText(true);

        foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(30);
        }
        foreach (['F', 'G', 'H'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(18);
        }
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(28);

        $ttd = $report['ttd'];
        $footerRow = $row + 3;

        $sheet->mergeCells('G' . $footerRow . ':H' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, 'SIAK SRI INDRAPURA, ' . now()->translatedFormat('d F Y'));
        $sheet->getStyle('G' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->mergeCells('G' . $footerRow . ':H' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, 'INSPEKTUR KABUPATEN SIAK');
        $sheet->getStyle('G' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow += 6;

        $sheet->mergeCells('G' . $footerRow . ':H' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, $ttd->nama_pegawai ?? '-');
        $sheet->getStyle('G' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
        $footerRow++;

        $sheet->mergeCells('G' . $footerRow . ':H' . $footerRow);
        $sheet->setCellValue('G' . $footerRow, 'NIP.' . ($ttd->id_pegawai ?? '-'));
        $sheet->getStyle('G' . $footerRow)->getAlignment()->applyFromArray($alignTopLeft);
    }
}
