<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstansiController extends Controller
{
    public function getMyTurunan(Request $request)
    {
        $kode_unor = $request->id;

        $query = Instansi::select(
            'nama_instansi',
            DB::raw('LEFT(kode_instansi,8) as kode_turunan')
        )
            ->whereRaw('CHAR_LENGTH(TRIM(kode_instansi)) = 8')
            ->where('kode_instansi', 'like', $kode_unor . '%')
            ->get();

        return response()->json([
            'error' => false,
            'data'  => $query,
            'msg'   => 'The request was fulfilled.'
        ]);
    }
}
