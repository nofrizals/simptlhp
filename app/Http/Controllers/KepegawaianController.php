<?php

namespace App\Http\Controllers;

use App\Models\PegawaiSimak;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class KepegawaianController extends Controller
{
    public function index()
    {
        return view('kepegawaian');
    }

    public function ajaxDt()
    {
        $data = PegawaiSimak::query();
        return DataTables::eloquent($data)
            ->addIndexColumn()
            ->addColumn('nama_pegawai', function ($value) {
                $nama = NULL;
                if ($value->gelar_nonakademis != NULL || $value->gelar_nonakademis != '-') {
                    $nama = $value->gelar_nonakademis . $value->nama_pegawai;
                }
                $nama = $value->gelar_depan . " " . $nama . ", " . $value->gelar_belakang;
                return '<span class="dark:text-white/90">' . $nama ?? '-' . '</span>';
            })
            ->addColumn('nip_baru', function ($value) {
                return '<span class="dark:text-white/90">' . "<code>" . $value->nip_baru . "</code>" ?? '-' . '</span>';
            })
            ->addColumn('ktp_nomor', function ($value) {
                return '<span class="dark:text-white/90">' . $value->ktp_nomor ?? '-' . '</span>';
            })
            ->addColumn('nama_golongan', function ($value) {
                return '<span class="dark:text-white/90">' . $value->nama_golongan . ' ' . $value->nama_pangkat ?? '-' . '</span>';
            })
            ->addColumn('nomenklatur_pada', function ($value) {
                return '<span class="dark:text-white/90">' . $value->nomenklatur_pada ?? '-' . '</span>';
            })
            ->addColumn('nomenklatur_jabatan', function ($value) {
                return '<span class="dark:text-white/90">' . $value->nomenklatur_jabatan ?? '-' . '</span>';
            })
            ->filterColumn('nama_pegawai', function (Builder $query, string $keyword) {
                $query->where('nama_pegawai', 'LIKE', "%{$keyword}%");
            })
            ->rawColumns(['nama_pegawai', 'nip_baru', 'ktp_nomor', 'nama_golongan', 'nomenklatur_pada', 'nomenklatur_jabatan'])
            ->make(true);
    }
}
