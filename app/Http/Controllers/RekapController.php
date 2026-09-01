<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exports\RekapApbkamExport;
use App\Exports\RekapPhpExport;
use App\Exports\RekapTnkExport;
use App\Exports\RekapTnkKolektifExport;
use App\Http\Requests\Rekap\FilterRekapApbkamRequest;
use App\Http\Requests\Rekap\FilterRekapKolektifRequest;
use App\Http\Requests\Rekap\FilterRekapRequest;
use App\Models\Instansi;
use App\Models\JenisPhp;
use App\Models\Kasus;
use App\Services\Rekap\RekapApbkamReportBuilder;
use App\Services\Rekap\RekapPhpReportBuilder;
use App\Services\Rekap\RekapTnkKolektifReportBuilder;
use App\Services\Rekap\RekapTnkReportBuilder;
use App\Services\Rekap\SimakUnorService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

final class RekapController extends Controller
{
    public function __construct(
        private readonly RekapPhpReportBuilder $phpReportBuilder,
        private readonly RekapTnkReportBuilder $tnkReportBuilder,
        private readonly RekapTnkKolektifReportBuilder $tnkKolektifReportBuilder,
        private readonly RekapApbkamReportBuilder $apbkamReportBuilder,
    ) {}

    /**
     * Tampilkan halaman filter + tabel Rekap PHP/TNK.
     */
    public function phpTnk(): View
    {
        return view('rekap.php-tnk', [
            'jenisPhpList'     => JenisPhp::query()->orderBy('jenis_php')->get(),
            'tahunPemeriksaan' => $this->getDistinctTahunPemeriksaan(),
            'instansiList'     => Instansi::query()->orderBy('nama_instansi')->get(),
        ]);
    }

    /**
     * Endpoint server-side Yajra DataTables untuk listing kasus sesuai filter.
     */
    public function data(FilterRekapRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $query = Kasus::query()
            ->with(['jenis_php', 'instansi'])
            ->whereNull('deleted_by')
            ->where('id_jenis_php', $filters['id_jenis_php']);

        if ($filters['tahun_pemeriksaan'] !== 'semua') {
            $query->where('tahun_pemeriksaan', $filters['tahun_pemeriksaan']);
        }

        if ($filters['kode_unor'] !== 'semua') {
            $query->where('kode_unor', $filters['kode_unor']);
        }

        if ($filters['status_kasus'] !== 'semua') {
            $query->where('selesai', $filters['status_kasus']);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('nomor_lhp_info', function (Kasus $kasus): string {
                $jenisPhp = $kasus->jenis_php?->jenis_php ?? '-';

                return sprintf(
                    '%s<br><code>%s - %s</code>',
                    e($kasus->nomor_lhp),
                    e((string) $kasus->tahun_pemeriksaan),
                    e($jenisPhp)
                );
            })
            ->addColumn('status_info', function (Kasus $kasus): string {
                return (int) $kasus->selesai === 1
                    ? '<span class="text-success">SELESAI</span>'
                    : '<span class="text-danger">BELUM SELESAI</span>';
            })
            ->editColumn('tanggal_lhp', function (Kasus $kasus): string {
                // Catatan: kolom `tanggal_lhp` belum di-cast ke datetime pada model Kasus,
                // jadi parsing dilakukan manual di sini. Idealnya tambahkan cast di model.
                return $kasus->tanggal_lhp
                    ? Carbon::parse($kasus->tanggal_lhp)->translatedFormat('d F Y')
                    : '';
            })
            ->addColumn('nama_obrik', function (Kasus $kasus): string {
                return $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor;
            })
            ->editColumn('created_at', function (Kasus $kasus): string {
                return $kasus->created_at
                    ? Carbon::parse($kasus->created_at)->translatedFormat('d F Y')
                    : '';
            })
            ->addColumn('action', function (Kasus $kasus): string {
                return view('rekap.partials._aksi-dropdown', ['kasus' => $kasus])->render();
            })
            ->rawColumns(['nomor_lhp_info', 'status_info', 'action'])
            ->toJson();
    }

    /**
     * Tampilkan hasil "Cetak PHP" untuk satu kasus, di-load ke #lembarRekap via AJAX.
     */
    public function cetakPhp(Kasus $kasus): View
    {
        $report = $this->phpReportBuilder->build($kasus);

        return view('rekap.partials.cetak-php', [
            'kasus'     => $kasus,
            'rows'      => $report['rows'],
            'totals'    => $report['totals'],
            'ttd'       => $report['ttd'],
            'ketuaTim'  => $report['ketuaTim'],
            'namaObrik' => $report['namaObrik'],
        ]);
    }

    /**
     * Tampilkan hasil "Cetak TNK" (rekap tindak lanjut) untuk satu kasus.
     */
    public function cetakTnk(Kasus $kasus): View
    {
        $report = $this->tnkReportBuilder->build($kasus);

        return view('rekap.partials.cetak-tnk', [
            'kasus'            => $kasus,
            'isTgr'            => $report['isTgr'],
            'temuanCount'      => $report['temuanCount'],
            'rekomendasiCount' => $report['rekomendasiCount'],
            'admin'            => $report['admin'],
            'keuangan'         => $report['keuangan'],
            'adminRatio'       => $report['adminRatio'],
            'keuanganRatio'    => $report['keuanganRatio'],
            'bk'               => $report['bk'],
            'setoran'          => $report['setoran'],
            'ttd'              => $report['ttd'],
            'namaObrik'        => $report['namaObrik'],
        ]);
    }

    /**
     * Export "Cetak PHP" ke file Excel (.xlsx).
     */
    public function exportPhp(Kasus $kasus): BinaryFileResponse
    {
        $namaObrik = $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor;
        $filename = 'MATRIK TINDAK LANJUT HASIL PEMERIKSAAN INSPEKTORAT DAERAH KABUPATEN SIAK PADA '
            . strtoupper($namaObrik) . '.xlsx';

        return Excel::download(new RekapPhpExport($kasus, $this->phpReportBuilder), $filename);
    }

    /**
     * Export "Cetak TNK" ke file Excel (.xlsx).
     */
    public function exportTnk(Kasus $kasus): BinaryFileResponse
    {
        $kasus->loadMissing('jenis_php');
        $filename = 'REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN '
            . $kasus->jenis_php?->jenis_php . ' TAHUN ' . $kasus->tahun_pemeriksaan . '.xlsx';

        return Excel::download(new RekapTnkExport($kasus, $this->tnkReportBuilder), $filename);
    }

    /**
     * Ambil daftar tahun pemeriksaan unik, diurutkan descending.
     *
     * @return \Illuminate\Support\Collection<int, string>
     */
    private function getDistinctTahunPemeriksaan(): \Illuminate\Support\Collection
    {
        return Kasus::query()
            ->select('tahun_pemeriksaan')
            ->whereNotNull('tahun_pemeriksaan')
            ->distinct()
            ->orderByDesc('tahun_pemeriksaan')
            ->pluck('tahun_pemeriksaan');
    }

    public function cetakTnkKolektif(FilterRekapKolektifRequest $request): View
    {
        $filters = $request->validated();

        $report = $this->tnkKolektifReportBuilder->build(
            (int) $filters['id_jenis_php'],
            $filters['tahun_pemeriksaan'],
            $filters['kode_unor'],
        );

        return view('rekap.partials.cetak-tnk-kolektif', [
            'isTgr'             => $report['isTgr'],
            'jenisPhpLabel'     => $report['jenisPhpLabel'],
            'namaInstansiLabel' => $report['namaInstansiLabel'],
            'rows'              => $report['rows'],
            'totals'            => $report['totals'],
            'ttd'               => $report['ttd'],
            'tahunPemeriksaan'  => $filters['tahun_pemeriksaan'],
            'filters'           => $filters,
        ]);
    }

    /**
     * Export "Cetak Kolektif TNK" ke file Excel (.xlsx).
     */
    public function exportTnkKolektif(FilterRekapKolektifRequest $request): BinaryFileResponse
    {
        $filters = $request->validated();

        $labelTahun = $filters['tahun_pemeriksaan'] === 'semua'
            ? 'SEMUA TAHUN'
            : 'TAHUN ' . $filters['tahun_pemeriksaan'];

        $filename = 'REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN KOLEKTIF '
            . $labelTahun . '.xlsx';

        return Excel::download(
            new RekapTnkKolektifExport(
                (int) $filters['id_jenis_php'],
                $filters['tahun_pemeriksaan'],
                $filters['kode_unor'],
                $this->tnkKolektifReportBuilder,
            ),
            $filename
        );
    }

    /**
     * Tampilkan halaman filter APBKAM.
     */
    public function apbkam(SimakUnorService $simakUnorService): View
    {
        return view('rekap.apbkam', [
            'kecamatanList'    => $simakUnorService->listKecamatan(),
            'tahunPemeriksaan' => $this->getDistinctTahunPemeriksaan(),
        ]);
    }

    /**
     * Tampilkan hasil rekap APBKAM (partial, di-load via AJAX ke #lembarRekap).
     */
    public function cetakApbkam(FilterRekapApbkamRequest $request): View
    {
        $filters = $request->validated();

        $report = $this->apbkamReportBuilder->build(
            $filters['tahun_pemeriksaan'],
            $filters['kode_unor'],
        );

        return view('rekap.partials.cetak-apbkam', [
            'kecamatanLabel'   => $report['kecamatanLabel'],
            'tahunPemeriksaan' => $report['tahunPemeriksaan'],
            'kampungRows'      => $report['kampungRows'],
            'grandTotal'       => $report['grandTotal'],
            'ttd'              => $report['ttd'],
            'filters'          => $filters,
        ]);
    }

    /**
     * Export APBKAM ke Excel.
     */
    public function exportApbkam(FilterRekapApbkamRequest $request): BinaryFileResponse
    {
        $filters = $request->validated();

        $kecamatanLabel = $this->apbkamReportBuilder->build(
            $filters['tahun_pemeriksaan'],
            $filters['kode_unor'],
        )['kecamatanLabel'];

        $filename = 'APBKAM INSPEKTORAT KABUPATEN SIAK ' . $kecamatanLabel;
        if ($filters['tahun_pemeriksaan'] !== 'semua') {
            $filename .= ' TAHUN ' . $filters['tahun_pemeriksaan'];
        }

        return Excel::download(
            new RekapApbkamExport($filters['tahun_pemeriksaan'], $filters['kode_unor'], $this->apbkamReportBuilder),
            $filename . '.xlsx'
        );
    }
}
