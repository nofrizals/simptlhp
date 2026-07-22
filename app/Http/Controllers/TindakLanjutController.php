<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use App\Models\Tindaklanjut;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
                        <a href="javascript:void(0)" data-id="' . $value->id_tindak_lanjut . '" class="btn-editTindakLanjut text-gray-500 hover:text-blue-600" title="Edit">Edit</a>
                        <a href="javascript:void(0)" data-id="' . $value->id_tindak_lanjut . '" class="btn-deleteTindakLanjut text-gray-500 hover:text-red-500" title="Hapus">Hapus</a>
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
            $validated['edited_by'] = (string) Auth::id();
            $validated['edited_at'] = now();
            $temuan->update($validated);
            $message = 'Data berhasil diupdate';
        } else {
            $validated['created_by'] = (string) Auth::id();
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

    public function destroy(Rekomendasi $rekomendasi): JsonResponse
    {
        $rekomendasi->update([
            'deleted_by' => (string) Auth::id(),
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
