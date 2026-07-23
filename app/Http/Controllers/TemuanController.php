<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Temuan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TemuanController extends Controller
{
    public function ajaxData(Request $request, Kasus $kasus): JsonResponse
    {
        $data = Temuan::query()
            ->active()
            ->where('id_kasus', $kasus->id_kasus)
            ->withCount(['rekomendasi as rekomendasi_count' => function (Builder $query): void {
                $query->whereNull('deleted_by');
            }])
            ->orderByDesc('id_temuan');

        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('total_rekomendasi', function (Temuan $value): string {
                $rekomendasiBadge = '<a href="javascript:void(0)" data-id="' . $value->id_temuan . '" '
                    . 'class="btn-openRekomendasi mt-1 inline-flex items-center gap-1 whitespace-nowrap rounded-full border border-yellow-500 bg-yellow-200 px-3 py-0.5 text-sm font-medium text-yellow-700 transition-all duration-200 hover:border-yellow-300 hover:bg-yellow-100 hover:text-yellow-800">'
                    . $value->rekomendasi_count . ' Rekomendasi</a>';
                return '<div class="flex flex-col items-center gap-1">' . $rekomendasiBadge . '</div>';
            })
            ->addColumn('temuan', function (Temuan $value): string {
                return e($value->temuan) ?: '-';
            })
            ->addColumn('penyebab', function (Temuan $value): string {
                return e($value->penyebab) ?: '-';
            })
            ->addColumn('besaran_kerugian', function (Temuan $value): string {
                return 'Rp ' . number_format((float) $value->besaran_kerugian, 0, ',', '.');
            })
            ->addColumn('besaran_kerugian2', function (Temuan $value): string {
                return 'Rp ' . number_format((float) $value->besaran_kerugian2, 0, ',', '.');
            })
            ->addColumn('besaran_kerugian3', function (Temuan $value): string {
                return 'Rp ' . number_format((float) $value->besaran_kerugian3, 0, ',', '.');
            })
            ->addColumn('besaran_kerugian4', function (Temuan $value): string {
                return 'Rp ' . number_format((float) $value->besaran_kerugian4, 0, ',', '.');
            })
            ->addColumn('log', function (Temuan $value): string {
                if ($value->edited_by) {
                    return 'Diedit oleh <strong>' . e($value->editedBy->nama_pegawai) . '</strong><br>'
                        . optional($value->edited_at)->translatedFormat('d F Y');
                }

                return 'Ditambah oleh <strong>' . e($value->createdBy->nama_pegawai) . '</strong><br>'
                    . optional($value->created_at)->translatedFormat('d F Y');
            })
            ->addColumn('action', function (Temuan $value): string {
                return '
                    <div class="flex items-center justify-center gap-3 px-4 py-2">
                        <a href="javascript:void(0)" data-id="' . $value->id_temuan . '" class="btn-editTemuan text-gray-500 hover:text-blue-600" title="Edit">Edit</a>
                        <a href="javascript:void(0)" data-id="' . $value->id_temuan . '" class="btn-deleteTemuan text-gray-500 hover:text-red-500" title="Hapus">Hapus</a>
                    </div>';
            })
            ->rawColumns(['total_rekomendasi', 'log', 'action'])
            ->make(true);
    }

    public function store(Request $request, Kasus $kasus): JsonResponse
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
            $temuan = Temuan::where('id_kasus', $kasus->id_kasus)
                ->findOrFail($request->integer('id'));
            $validated['edited_by'] = (string) Auth::id();
            $validated['edited_at'] = now();
            $temuan->update($validated);
            $message = 'Data berhasil diupdate';
        } else {
            $validated['created_by'] = (string) Auth::id();
            $validated['created_at'] = now();
            $temuan = Temuan::create($validated);
            $message = 'Data berhasil ditambahkan';
        }

        return response()->json([
            'status'  => (bool) $temuan,
            'message' => $temuan ? $message : 'Gagal menyimpan data',
        ]);
    }

    public function edit($id): JsonResponse
    {
        $temuan = Temuan::with('kasus')->findOrFail($id);
        return response()->json([
            'id'                 => $temuan->id_temuan,
            'id_kasus'           => $temuan->id_kasus,
            'temuan'             => $temuan->temuan,
            'penyebab'           => $temuan->penyebab,
            'id_nilai_kerugian'  => $temuan->id_nilai_kerugian,
            'besaran_kerugian'   => $temuan->besaran_kerugian,
            'id_nilai_kerugian2' => $temuan->id_nilai_kerugian2,
            'besaran_kerugian2'  => $temuan->besaran_kerugian2,
            'id_nilai_kerugian3' => $temuan->id_nilai_kerugian3,
            'besaran_kerugian3'  => $temuan->besaran_kerugian3,
            'id_nilai_kerugian4' => $temuan->id_nilai_kerugian4,
            'besaran_kerugian4'  => $temuan->besaran_kerugian4,
            'nomor_lhp'          => $temuan->kasus->nomor_lhp,
            'tanggal_lhp'        => Carbon::parse($temuan->kasus->tanggal_lhp ?? '-')->translatedFormat('d F Y'),
            'id_jenis_php'       => $temuan->kasus->id_jenis_php,
            'kode_unor'          => $temuan->kasus->kode_unor,
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
