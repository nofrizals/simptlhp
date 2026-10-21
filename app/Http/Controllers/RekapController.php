<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exports\RekapApbkamExport;
use App\Exports\RekapPertahunExport;
use App\Exports\RekapPhpExport;
use App\Exports\RekapTnkExport;
use App\Exports\RekapTnkKolektifExport;
use App\Http\Requests\Rekap\FilterRekapApbkamRequest;
use App\Http\Requests\Rekap\FilterRekapKolektifRequest;
use App\Http\Requests\Rekap\FilterRekapPertahunRequest;
use App\Http\Requests\Rekap\FilterRekapRequest;
use App\Models\Instansi;
use App\Models\JenisPhp;
use App\Models\Kasus;
use App\Models\Unor;
use App\Services\Rekap\RekapApbkamReportBuilder;
use App\Services\Rekap\RekapPertahunReportBuilder;
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
        private readonly RekapPertahunReportBuilder $pertahunReportBuilder,
    ) {}

    public function phpTnk(): View
    {
        return view('rekap.php-tnk', [
            'jenisPhpList'      => JenisPhp::query()->whereNull('deleted_at')->orderBy('jenis_php')->get(),
            'tahunPemeriksaan'  => $this->getDistinctTahunPemeriksaan(),
            'instansiList'      => Unor::instansi()->get(),
            'kecamatanList'     => Unor::kecamatan()->get(),
            'turunanList'       => Instansi::readTurunan(),
            'obrikList'         => Instansi::read(true)
        ]);
    }

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
            ->editColumn('spt', function (Kasus $kasus): string {
                return '<span class="dark:text-white/90">' . e($kasus->spt) . '</span>';
            })
            ->addColumn('nomor_lhp_info', function (Kasus $kasus): string {
                $jenisPhp = $kasus->jenis_php?->jenis_php ?? '-';
                return sprintf(
                    '%s<br><code>%s - %s</code>',
                    '<span class="dark:text-white/90">' . e($kasus->nomor_lhp),
                    e((string) $kasus->tahun_pemeriksaan),
                    e($jenisPhp) . '</span>'
                );
            })
            ->addColumn('status_info', function (Kasus $kasus): string {
                return (int) $kasus->selesai === 1
                    ? '<span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs text-green-700 ring-green-600/20 dark:bg-green-500/20 dark:text-green-400">SELESAI</span>'
                    : '<span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs text-red-700 ring-red-600/20 dark:bg-red-500/20 dark:text-red-400">BELUM SELESAI</span>';
            })
            ->editColumn('tanggal_lhp', function (Kasus $kasus): string {
                return $kasus->tanggal_lhp
                    ? '<span class="dark:text-white/90">' . Carbon::parse($kasus->tanggal_lhp)->translatedFormat('d F Y') . '</span>'
                    : '';
            })
            ->addColumn('nama_obrik', function (Kasus $kasus): string {
                return '<span class="dark:text-white/90">' . $kasus->instansi?->nama_instansi ?? $kasus->kode_unor . '</span>';
            })
            ->editColumn('created_at', function (Kasus $kasus): string {
                return $kasus->created_at
                    ? '<span class="dark:text-white/90">' . Carbon::parse($kasus->created_at)->translatedFormat('d F Y') . '</span>'
                    : '';
            })
            ->addColumn('action', function (Kasus $kasus): string {
                return view('rekap.partials._aksi-dropdown', ['kasus' => $kasus])->render();
            })
            ->rawColumns(['spt', 'nomor_lhp_info', 'status_info', 'tanggal_lhp', 'created_at', 'nama_obrik', 'action'])
            ->toJson();
    }

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

    public function exportPhp(Kasus $kasus): BinaryFileResponse
    {
        $namaObrik = $kasus->instansi?->nama_instansi ?? (string) $kasus->kode_unor;
        $filename = 'MATRIK TINDAK LANJUT HASIL PEMERIKSAAN INSPEKTORAT DAERAH KABUPATEN SIAK PADA '
            . strtoupper($namaObrik) . '.xlsx';

        return Excel::download(new RekapPhpExport($kasus, $this->phpReportBuilder), $filename);
    }

    public function exportTnk(Kasus $kasus): BinaryFileResponse
    {
        $kasus->loadMissing('jenis_php');
        $filename = 'REKAPITULASI TINDAK LANJUT HASIL PEMERIKSAAN '
            . $kasus->jenis_php?->jenis_php . ' TAHUN ' . $kasus->tahun_pemeriksaan . '.xlsx';

        return Excel::download(new RekapTnkExport($kasus, $this->tnkReportBuilder), $filename);
    }

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

    public function apbkam(SimakUnorService $simakUnorService): View
    {
        return view('rekap.apbkam', [
            'kecamatanList'    => $simakUnorService->listKecamatan(),
            'tahunPemeriksaan' => $this->getDistinctTahunPemeriksaan(),
        ]);
    }

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

    public function pertahun(): View
    {
        return view('rekap.pertahun', [
            'jenisPhpList' => JenisPhp::whereNull('deleted_by')->orderBy('jenis_php')->get(),
        ]);
    }

    public function cetakPertahun(FilterRekapPertahunRequest $request): View
    {
        $filters = $request->validated();
        $report = $this->pertahunReportBuilder->build((int) $filters['id_jenis_php']);

        return view('rekap.partials.cetak-pertahun', [
            'isTgr'      => $report['isTgr'],
            'judulJenis' => $report['judulJenis'],
            'subJudul'   => $report['subJudul'],
            'rows'       => $report['rows'],
            'totals'     => $report['totals'],
            'ttd'        => $report['ttd'],
            'filters'    => $filters,
        ]);
    }

    public function exportPertahun(FilterRekapPertahunRequest $request): BinaryFileResponse
    {
        $filters = $request->validated();
        $idJenisPhp = (int) $filters['id_jenis_php'];

        $judulJenis = match ($idJenisPhp) {
            1 => ' (REGULER)',
            2 => ' (ADD)',
            default => '',
        };

        $filename = 'REKAPITULASI TEMUAN HASIL PEMERIKSAAN INSPEKTORAT KABUPATEN SIAK' . $judulJenis . '.xlsx';

        return Excel::download(
            new RekapPertahunExport($idJenisPhp, $this->pertahunReportBuilder),
            $filename
        );
    }
}
