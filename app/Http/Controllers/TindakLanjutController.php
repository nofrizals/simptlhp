<?php

namespace App\Http\Controllers;

use App\Models\Rekomendasi;
use App\Models\Temuan;
use App\Models\Tindaklanjut;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TindakLanjutController extends Controller
{
    public function ajaxData(Request $request, Rekomendasi $rekomendasi): JsonResponse
    {
        $data = Tindaklanjut::query()
            ->where('id_rekomendasi', $rekomendasi->id_rekomendasi)
            ->orderByDesc('id_rekomendasi');

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('tgl_tindak_lanjut', function (Tindaklanjut $value): string {
                return Carbon::parse($value->tgl_tindak_lanjut ?? '-')->translatedFormat('d F Y');
            })
            ->addColumn('tindak_lanjut', function (Tindaklanjut $value): string {
                return e($value->tindak_lanjut) ?: '-';
            })
            ->addColumn('rincian_temuan_keuangan_pajak', function (Tindaklanjut $value): string {
                $rincian = 'Rp ' . number_format((float) $value->rincian_keuangan, 2, ',', '.');
                $setor = 'Rp ' . number_format((float) $value->setor, 2, ',', '.');

                return $rincian .
                    "<br><div class='text-red-400'>SETOR {$setor}</div>";
            })
            ->addColumn('rincian_temuan_keuangan_daerah', function (Tindaklanjut $value): string {
                $rincian = 'Rp ' . number_format((float) $value->rincian_keuangan2, 2, ',', '.');
                $setor = 'Rp ' . number_format((float) $value->setor2, 2, ',', '.');

                return $rincian .
                    "<br><div class='text-red-400'>SETOR {$setor}</div>";
            })
            ->addColumn('rincian_temuan_keuangan_desa', function (Tindaklanjut $value): string {
                $rincian = 'Rp ' . number_format((float) $value->rincian_keuangan3, 2, ',', '.');
                $setor = 'Rp ' . number_format((float) $value->setor3, 2, ',', '.');

                return $rincian .
                    "<br><div class='text-red-400'>SETOR {$setor}</div>";
            })
            ->addColumn('rincian_temuan_keuangan_blud', function (Tindaklanjut $value): string {
                $rincian = 'Rp ' . number_format((float) $value->rincian_keuangan4, 2, ',', '.');
                $setor = 'Rp ' . number_format((float) $value->setor4, 2, ',', '.');

                return $rincian .
                    "<br><div class='text-red-400'>SETOR {$setor}</div>";
            })
            ->addColumn('status_tindak_lanjut', function (Tindaklanjut $value): string {
                return e($value->status->status_tl) ?: '-';
            })
            ->addColumn('keterangan', function (Tindaklanjut $value): string {
                return e($value->keterangan) ?: '-';
            })
            ->addColumn('log', function (Tindaklanjut $value): string {

                $status = $value->deleted_by === null
                    ? '<span class="inline-flex items-center rounded-full border border-green-200 bg-green-100 px-3 py-1 text-xs font-medium text-green-700">Aktif</span>'
                    : '<span class="inline-flex items-center rounded-full border border-red-200 bg-red-100 px-3 py-1 text-xs font-medium text-red-700">Tidak Aktif</span>';

                if ($value->edited_by) {
                    $log = 'Diedit oleh <strong>' . e($value->edited_by) . '</strong><br>'
                        . optional($value->edited_at)->translatedFormat('d F Y');
                } else {
                    $log = 'Ditambah oleh <strong>' . e($value->createdBy->nama_pegawai) . '</strong><br>'
                        . optional($value->created_at)->translatedFormat('d F Y');
                }

                return $status . '<br>' . $log;
            })
            ->addColumn('action', function (Tindaklanjut $value): string {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <a href="javascript:void(0)"
                            data-id="' . $value->id_tindak_lanjut . '"
                            class="tablinks fileTindakLanjut text-gray-500 hover:text-blue-600 transition duration-200"
                            title="File"
                            data-open="tabFileTindakLanjut">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.375 2.625C5.33947 2.625 4.5 3.46447 4.5 4.5V16.5C4.5 17.5355 5.33947 18.375 6.375 18.375H14.625C15.6605 18.375 16.5 17.5355 16.5 16.5V7.125L12 2.625H6.375ZM12 3.75L15.375 7.125H12V3.75ZM7.5 9.375H13.5V10.5H7.5V9.375ZM7.5 12H13.5V13.125H7.5V12ZM7.5 14.625H11.25V15.75H7.5V14.625Z" fill=""/>
                            </svg>
                        </a>
                        <a href="javascript:void(0)"
                            data-id="' . $value->id_tindak_lanjut . '"
                            class="tablinks pembayaran text-gray-500 hover:text-amber-500 transition duration-200"
                            title="Pembayaran"
                            data-open="tabPembayaran">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.75 5.25C3.12868 5.25 2.625 5.75368 2.625 6.375V14.625C2.625 15.2463 3.12868 15.75 3.75 15.75H17.25C17.8713 15.75 18.375 15.2463 18.375 14.625V6.375C18.375 5.75368 17.8713 5.25 17.25 5.25H3.75ZM3.75 6.75H17.25V8.25H3.75V6.75ZM6 11.25C6.62132 11.25 7.125 11.7537 7.125 12.375C7.125 12.9963 6.62132 13.5 6 13.5C5.37868 13.5 4.875 12.9963 4.875 12.375C4.875 11.7537 5.37868 11.25 6 11.25ZM9 11.625H15.75V12.75H9V11.625Z" fill=""/>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $value->id_tindak_lanjut . '" title="Hapus" class="btn-deleteTindakLanjut text-gray-500 hover:text-red-500 transition duration-200">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.54142 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" fill=""/>
                            </svg>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $value->id_tindak_lanjut . '"  class="btn-editTindakLanjut text-gray-500 hover:text-blue-600 transition duration-200" title="Edit">
                            <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z" fill=""/></svg>
                        </a>
                    </div>';
            })
            ->rawColumns([
                'rincian_temuan_keuangan_pajak',
                'rincian_temuan_keuangan_daerah',
                'rincian_temuan_keuangan_desa',
                'rincian_temuan_keuangan_blud',
                'log',
                'action'
            ])
            ->make(true);
    }

    public function store(Request $request, Rekomendasi $rekomendasi): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tindak_lanjut'      => 'nullable|string',
            'rincian_keuangan'   => 'nullable|numeric|lte:besaran_kerugian',
            'setor'              => 'nullable|numeric|lte:rincian_keuangan',
            'rincian_keuangan2'  => 'nullable|numeric|lte:besaran_kerugian2',
            'setor2'             => 'nullable|numeric|lte:rincian_keuangan2',
            'rincian_keuangan3'  => 'nullable|numeric|lte:besaran_kerugian3',
            'setor3'             => 'nullable|numeric|lte:rincian_keuangan3',
            'rincian_keuangan4'  => 'nullable|numeric|lte:besaran_kerugian4',
            'setor4'             => 'nullable|numeric|lte:rincian_keuangan4',
            'id_status'          => 'required',
            'keterangan'         => 'nullable|string',
            'tgl_tindak_lanjut'  => 'required|date',
        ], [
            'rincian_keuangan.lte'       => 'Rincian melebihi nilai kerugian.',
            'setor.lte'                  => 'Setoran melebihi nominal rincian.',
            'rincian_keuangan2.lte'      => 'Rincian melebihi nilai kerugian.',
            'setor2.lte'                 => 'Setoran melebihi nominal rincian.',
            'rincian_keuangan3.lte'      => 'Rincian melebihi nilai kerugian.',
            'setor3.lte'                 => 'Setoran melebihi nominal rincian.',
            'rincian_keuangan4.lte'      => 'Rincian melebihi nilai kerugian.',
            'setor4.lte'                 => 'Setoran melebihi nominal rincian.',
            'id_status.required'         => 'Status tindak lanjut wajib diisi.',
            'tgl_tindak_lanjut.required' => 'Tanggal tindak lanjut wajib diisi.',
            'tgl_tindak_lanjut.date'     => 'Tanggal tindak lanjut tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors(),
            ]);
        }

        $validated = $validator->safe()->except('id');
        $validated['id_rekomendasi'] = $rekomendasi->id_rekomendasi;

        if ($request->filled('id')) {
            $temuan = Tindaklanjut::where('id_rekomendasi', $rekomendasi->id_rekomendasi)
                ->findOrFail($request->integer('id'));
            $validated['edited_by'] = (string) session('id_pegawai');
            $validated['edited_at'] = now();
            $temuan->update($validated);
            $message = 'Data berhasil diupdate';
        } else {
            $validated['created_by'] = (string) session('id_pegawai');
            $validated['created_at'] = now();
            $temuan = Tindaklanjut::create($validated);
            $message = 'Data berhasil ditambahkan';
        }

        return response()->json([
            'status'  => (bool) $temuan,
            'message' => $temuan ? $message : 'Gagal menyimpan data',
        ]);
    }

    public function edit(Tindaklanjut $tindaklanjut): JsonResponse
    {
        return response()->json([
            'id'                 => $tindaklanjut->id_tindak_lanjut,
            'id_rekomendasi'     => $tindaklanjut->id_rekomendasi,
            'tindak_lanjut'      => $tindaklanjut->tindak_lanjut
        ]);
    }

    public function destroy(Tindaklanjut $tindaklanjut): JsonResponse
    {
        $tindaklanjut->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function getTemuanKerugian(Request $request)
    {
        $request->validate([
            'id_temuan' => 'required|exists:kis_temuans,id_temuan'
        ]);
        $temuan = Temuan::findOrFail($request->id_temuan);
        return response()->json([
            'id_nilai_kerugian'   => $temuan->id_nilai_kerugian,
            'besaran_kerugian'    => $temuan->besaran_kerugian,
            'id_nilai_kerugian2'  => $temuan->id_nilai_kerugian2,
            'besaran_kerugian2'   => $temuan->besaran_kerugian2,
            'id_nilai_kerugian3'  => $temuan->id_nilai_kerugian3,
            'besaran_kerugian3'   => $temuan->besaran_kerugian3,
            'id_nilai_kerugian4'  => $temuan->id_nilai_kerugian4,
            'besaran_kerugian4'   => $temuan->besaran_kerugian4,
        ]);
    }

    public function cekTindakLanjut(Request $request)
    {
        $exists = Tindaklanjut::where('id_rekomendasi', $request->id_rekomendasi)->whereNull('deleted_by')->exists();
        return response()->json([
            'exists' => $exists
        ]);
    }
}
