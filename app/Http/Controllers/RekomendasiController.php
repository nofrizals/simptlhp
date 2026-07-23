<?php

namespace App\Http\Controllers;

use App\Models\Rekomendasi;
use App\Models\Temuan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RekomendasiController extends Controller
{
    public function ajaxData(Request $request, Temuan $temuan): JsonResponse
    {
        $data = Rekomendasi::query()
            ->where('id_temuan', $temuan->id_temuan)
            ->withCount('tindakLanjuts')
            ->with('tindakLanjutAktif.status')
            ->orderByDesc('id_temuan');

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('tindak_lanjut', function (Rekomendasi $value) {
                if ($value->tindak_lanjuts_count > 0) {
                    $status = $value->tindakLanjutAktif?->status?->status_tl ?? '';
                    return '<a href="javascript:void(0)" data-id="' . $value->id_rekomendasi . '"
                        class="mt-1 inline-flex items-center text-center gap-1 rounded-full border border-yellow-500 bg-yellow-200 px-3 py-0.5 text-sm font-medium text-yellow-700 transition-all duration-200 hover:border-yellow-300 hover:bg-yellow-100 hover:text-yellow-800 btn-openTindakLanjut">
                        Tindak Lanjut ' . $status . '
                    </a>';
                }
                return '<a href="javascript:void(0)" data-id="' . $value->id_rekomendasi . '"
                    class="mt-1 inline-flex items-center gap-1 whitespace-nowrap rounded-full border border-blue-500 bg-blue-200 px-3 py-0.5 text-sm font-medium text-blue-700 transition-all duration-200 hover:border-blue-300 hover:bg-blue-100 hover:text-blue-800 btn-openTindakLanjut">
                    Tindak Lanjut
                </a>';
            })
            ->addColumn('rekomendasi', function (Rekomendasi $value): string {
                return e($value->rekomendasi) ?: '-';
            })
            ->addColumn('tgl_input', function (Rekomendasi $value): string {
                return Carbon::parse($value->created_at ?? '-')->translatedFormat('d F Y');
            })
            ->addColumn('log', function (Rekomendasi $value): string {
                if ($value->edited_by) {
                    return 'Diedit oleh <strong>' . e($value->editedBy->nama_pegawai) . '</strong><br>'
                        . optional($value->edited_at)->translatedFormat('d F Y');
                }
                return 'Ditambah oleh <strong>' . e($value->createdBy->nama_pegawai) . '</strong><br>'
                    . optional($value->created_at)->translatedFormat('d F Y');
            })
            ->addColumn('action', function (Rekomendasi $value): string {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <a href="javascript:void(0)" data-id="' . $value->id_rekomendasi . '" class="btn-editRekomendasi text-gray-500 hover:text-blue-600" title="Edit">Edit</a>
                        <a href="javascript:void(0)" data-id="' . $value->id_rekomendasi . '" class="btn-deleteRekomendasi text-gray-500 hover:text-red-500" title="Hapus">Hapus</a>
                    </div>';
            })
            ->rawColumns(['tindak_lanjut', 'log', 'action'])
            ->make(true);
    }

    public function store(Request $request, Temuan $temuan): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id'                 => ['nullable', 'integer', 'exists:kis_temuans,id_temuan'],
            'temuan'             => ['required', 'string'],
            'penyebab'           => ['required', 'string'],
            'id_nilai_kerugian'  => ['nullable', 'integer'],
            'besaran_kerugian'   => ['nullable', 'numeric', 'min:0'],
            'id_nilai_kerugian2' => ['nullable', 'integer'],
            'besaran_kerugian2'  => ['nullable', 'numeric', 'min:0'],
            'id_nilai_kerugian3' => ['nullable', 'integer'],
            'besaran_kerugian3'  => ['nullable', 'numeric', 'min:0'],
            'id_nilai_kerugian4' => ['nullable', 'integer'],
            'besaran_kerugian4'  => ['nullable', 'numeric', 'min:0'],
        ], [
            'temuan.required'   => 'Temuan wajib diisi',
            'penyebab.required' => 'Penyebab wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors(),
            ]);
        }

        $validated = $validator->safe()->except('id');
        $validated['id_kasus'] = $kasus->id_kasus;

        // Kolom id_nilai_kerugian2/3/4 di DB tidak punya default → jaga-jaga
        $validated['id_nilai_kerugian']  ??= 0;
        $validated['id_nilai_kerugian2'] ??= 0;
        $validated['id_nilai_kerugian3'] ??= 0;
        $validated['id_nilai_kerugian4'] ??= 0;

        if ($request->filled('id')) {
            $temuan = Rekomendasi::where('id_kasus', $kasus->id_kasus)
                ->findOrFail($request->integer('id'));
            $validated['edited_by'] = (string) Auth::id();
            $validated['edited_at'] = now();
            $temuan->update($validated);
            $message = 'Data berhasil diupdate';
        } else {
            $validated['created_by'] = (string) Auth::id();
            $validated['created_at'] = now();
            $temuan = Rekomendasi::create($validated);
            $message = 'Data berhasil ditambahkan';
        }

        return response()->json([
            'status'  => (bool) $temuan,
            'message' => $temuan ? $message : 'Gagal menyimpan data',
        ]);
    }

    public function edit($id): JsonResponse
    {
        $data = Rekomendasi::with('temuan.kasus.jenis_php')->findOrFail($id);
        return response()->json([
            'tanggal_lhp'        => $data->temuan->kasus->tanggal_lhp ?? '-',
            'nomor_lhp'          => $data->temuan->kasus->nomor_lhp ?? '-',
            'kode_unor'          => $data->temuan->kasus->kode_unor ?? '-',
            'id_jenis_php'       => $data->temuan->kasus->jenis_php->jenis_php ?? '-',
            'temuan'             => $data->temuan->temuan ?? '-',
            'penyebab'           => $data->temuan->penyebab ?? '-',
            'rekomendasi'        => $data->rekomendasi
        ]);
    }

    public function destroy(Temuan $temuan): JsonResponse
    {
        $temuan->update([
            'deleted_by' => (string) Auth::id(),
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
