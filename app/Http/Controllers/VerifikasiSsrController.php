<?php

namespace App\Http\Controllers;

use App\Models\FileTindakLanjut;
use App\Models\Pembayaran;
use App\Models\Tindaklanjut;
use App\Models\VerifikasiSsr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VerifikasiSsrController extends Controller
{
    public function index()
    {
        return view('pages.manajemen-kasus.verifikasi-ssr');
    }

    public function ajaxDataVerifikasiSsr()
    {
        $data = VerifikasiSsr::with(['status', 'rekomendasi'])->orderBy('id', 'desc');
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('tgl_tindak_lanjut', function ($value) {
                return Carbon::parse($value->tgl_tindak_lanjut ?? '-')->translatedFormat('d F Y');
            })
            ->addColumn('tindak_lanjut', function ($value) {
                return $value->tindak_lanjut ?? '-';
            })
            ->addColumn('rincian_keuangan', function ($value) {
                return $value->rincian_keuangan !== null ? 'Rp ' . number_format($value->rincian_keuangan, 0, ',', '.') : '-';
            })->addColumn('rincian_keuangan2', function ($value) {
                return $value->rincian_keuangan2 !== null ? 'Rp ' . number_format($value->rincian_keuangan2, 0, ',', '.') : '-';
            })->addColumn('rincian_keuangan3', function ($value) {
                return $value->rincian_keuangan3 !== null ? 'Rp ' . number_format($value->rincian_keuangan3, 0, ',', '.') : '-';
            })->addColumn('rincian_keuangan4', function ($value) {
                return $value->rincian_keuangan4 !== null ? 'Rp ' . number_format($value->rincian_keuangan4, 0, ',', '.') : '-';
            })
            ->addColumn('id_status', function ($value) {
                return $value->status->status_tl ?? '-';
            })
            ->addColumn('keterangan', function ($value) {
                return $value->keterangan ?? '-';
            })
            ->addColumn('log', function ($value) {

                if ($value->approve_by) {
                    $log = 'Disetujui oleh <strong>' . e($value->approveBy->nama_pegawai) . '</strong><br>'
                        . optional(Carbon::parse($value->approve_at ?? '-'))->translatedFormat('d F Y');
                } else if ($value->reject_by) {
                    $log = 'Ditolak oleh <strong>' . e($value->rejectBy->nama_pegawai) . '</strong><br>'
                        . optional(Carbon::parse($value->reject_at ?? '-'))->translatedFormat('d F Y');
                } else {
                    $log = 'Ditambah oleh <strong>' . e($value->createdBy->nama_pegawai) . '</strong><br>'
                        . optional(Carbon::parse($value->created_at ?? '-'))->translatedFormat('d F Y');
                }

                return $log;
            })
            ->addColumn('action', function ($value) {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <a href="' . url('verifikasi-ssr/approve/' . $value->label) . '"
                            class="btn-approve text-blue-800 hover:text-blue-500 transition duration-200"
                            title="Approve">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 2.625H4.5C3.464 2.625 2.625 3.464 2.625 4.5V16.5C2.625 17.536 3.464 18.375 4.5 18.375H16.5C17.536 18.375 18.375 17.536 18.375 16.5V4.5C18.375 3.464 17.536 2.625 16.5 2.625ZM8.25 15.375L4.875 12L6.375 10.5L8.25 12.375L14.625 6L16.125 7.5L8.25 15.375Z" fill="currentColor"/>
                            </svg>
                        </a>
                    </div>';
            })
            ->filterColumn('tindak_lanjut', function (Builder $query, string $keyword) {
                $query->where(function (Builder $q) use ($keyword) {
                    foreach (VerifikasiSsr::SEARCHABLE_COLUMNS as $i => $column) {
                        $method = $i === 0 ? 'where' : 'orWhere';
                        $q->{$method}($column, 'LIKE', "%{$keyword}%");
                    }
                });
            })
            ->rawColumns(['tgl_tindak_lanjut', 'tindak_lanjut', 'rincian_keuangan', 'rincian_keuangan2', 'rincian_keuangan3', 'rincian_keuangan4', 'id_status', 'log', 'action'])
            ->make(true);
    }

    public function approve($label)
    {
        $temuan = VerifikasiSsr::where('label', $label)->first();
        return view('pages.manajemen-kasus.form-approve-ssr', [
            'label' => $label,
            'tindak_lanjut' => $temuan->id_tindak_lanjut
        ]);
    }

    public function info($label)
    {
        $data = VerifikasiSsr::with(['tindakLanjut', 'rekomendasi.temuan.kasus', 'status'])->where('label', $label)->firstOrFail();
        return response()->json([
            'id'                => $data->id,
            'oleh'              => $data->tindakLanjut->created_by,
            'tanggal_lhp'       => $data->rekomendasi->temuan->kasus->tanggal_lhp,
            'nomor_lhp'         => $data->rekomendasi->temuan->kasus->nomor_lhp,
            'nama_obrik'        => $data->rekomendasi->temuan->kasus->kode_unor,
            'jenis_php'         => $data->rekomendasi->temuan->kasus->id_jenis_php,
            'temuan'            => $data->rekomendasi->temuan->temuan,
            'penyebab'          => $data->rekomendasi->temuan->penyebab,
            'rekomendasi'       => $data->rekomendasi->rekomendasi,
            'tgl_tindak_lanjut' => $data->tindakLanjut->tgl_tindak_lanjut,
            'tindak_lanjut'     => $data->tindakLanjut->tindak_lanjut,
            'keterangan'        => $data->tindakLanjut->keterangan
        ]);
    }

    public function getTindakLanjutKerugian(Request $request)
    {
        $request->validate([
            'id_tindak_lanjut' => 'required|exists:kis_tindak_lanjuts,id_tindak_lanjut'
        ]);
        $tindak_lanjut = Tindaklanjut::with('rekomendasi.temuan')->findOrFail($request->id_tindak_lanjut);
        return response()->json([
            'id_nilai_kerugian'   => $tindak_lanjut->rekomendasi->temuan->id_nilai_kerugian,
            'besaran_kerugian'    => $tindak_lanjut->rekomendasi->temuan->besaran_kerugian,
            'rincian_keuangan'    => $tindak_lanjut->rincian_keuangan,
            'id_nilai_kerugian2'  => $tindak_lanjut->rekomendasi->temuan->id_nilai_kerugian2,
            'besaran_kerugian2'   => $tindak_lanjut->rekomendasi->temuan->besaran_kerugian2,
            'rincian_keuangan2'   => $tindak_lanjut->rincian_keuangan2,
            'id_nilai_kerugian3'  => $tindak_lanjut->rekomendasi->temuan->id_nilai_kerugian3,
            'besaran_kerugian3'   => $tindak_lanjut->rekomendasi->temuan->besaran_kerugian3,
            'rincian_keuangan3'   => $tindak_lanjut->rincian_keuangan3,
            'id_nilai_kerugian4'  => $tindak_lanjut->rekomendasi->temuan->id_nilai_kerugian4,
            'besaran_kerugian4'   => $tindak_lanjut->rekomendasi->temuan->besaran_kerugian4,
            'rincian_keuangan4'   => $tindak_lanjut->rincian_keuangan4,
        ]);
    }

    public function ajaxRiwayatPembayaran($id_tindak_lanjut)
    {
        $data = Pembayaran::where('id_tindak_lanjut', $id_tindak_lanjut)->orderBy('id', 'desc');
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('jenis', function (Pembayaran $value): string {
                return e(ucwords($value->jenis)) ?: '-';
            })
            ->addColumn('tanggal', function (Pembayaran $value): string {
                return Carbon::parse($value->created_at ?? '-')->translatedFormat('d F Y');
            })
            ->addColumn('bukti', function (Pembayaran $value): string {
                if (!$value->file_bukti) {
                    return '-';
                }
                $url = asset('storage/' . $value->file_bukti);
                return '<a href="' . e($url) . '" target="_blank">
                <img src="' . asset('images/pdf.png') . '" alt="PDF" width="40">
            </a>';
            })
            ->addColumn('nominal', function (Pembayaran $value): string {
                return 'Rp ' . number_format((float) $value->nominal, 2, ',', '.');
            })
            ->rawColumns(['jenis', 'tanggal', 'bukti', 'nominal'])
            ->make(true);
    }

    public function ajaxBuktiPembayaran($id_tindak_lanjut)
    {
        $data = FileTindakLanjut::where('id_tindak_lanjut', $id_tindak_lanjut)->orderByDesc('id_tindak_lanjut');
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('file', function ($value): string {
                if (!$value->file) {
                    return '-';
                }
                $url = asset('storage/' . $value->file);
                return '<a href="' . e($url) . '" target="_blank">
                <img src="' . asset('images/pdf.png') . '" alt="PDF" width="40">
            </a>';
            })
            ->addColumn('log', function ($value): string {

                $status = $value->deleted_by === null
                    ? '<span class="inline-flex items-center rounded-full border border-green-200 bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Aktif</span>'
                    : '<span class="inline-flex items-center rounded-full border border-red-200 bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Tidak Aktif</span>';
                $log = 'Ditambah oleh <strong>' . e($value->createdBy->nama_pegawai) . '</strong><br>'
                    . optional(Carbon::parse($value->created_at ?? '-'))->translatedFormat('d F Y');

                return $status . '<br>' . $log;
            })
            ->addColumn('action', function ($value): string {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <a href="javascript:void(0)" data-id="' . $value->id . '" title="Hapus" class="btn-deleteUploadFile text-gray-500 hover:text-red-500 transition duration-200">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""/>
                            </svg>
                        </a>
                    </div>';
            })
            ->rawColumns(['file', 'log', 'action'])
            ->make(true);
    }
}
