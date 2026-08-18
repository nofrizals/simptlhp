<?php

namespace App\Http\Controllers;

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
}
