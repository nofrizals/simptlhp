<?php

namespace App\Http\Controllers;

use App\Models\FileTindakLanjut;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FileTindakLanjutController extends Controller
{
    public function ajaxUploadFile(Request $request, $id_tindak_lanjut): JsonResponse
    {
        $data = FileTindakLanjut::query()
            ->where('id_tindak_lanjut', $id_tindak_lanjut)
            ->orderByDesc('id_tindak_lanjut');
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

    public function storeFile(Request $request, $id_tindak_lanjut): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|array',
            'file.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'file.required' => 'Gambar tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        $uploadedFiles = [];
        try {
            foreach ($request->file('file') as $file) {
                $path = $file->store('multiple_upload', 'public');
                $uploadedFiles[] = $path;
                FileTindakLanjut::create([
                    'id_tindak_lanjut' => $id_tindak_lanjut,
                    'file'             => $path,
                    'created_by'       => session('id_pegawai'),
                    'created_at'       => now(),
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Upload berhasil',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($uploadedFiles as $path) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyFileTindakLanjut($id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $file_upload = FileTindakLanjut::findOrFail($id);
            $file = $file_upload->file;
            $file_upload->delete();
            DB::commit();
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
