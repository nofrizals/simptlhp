<?php

namespace App\Services;

use App\Models\VerifikasiSsr;
use Illuminate\Support\Facades\DB;

class HitungService
{
    /**
     * Menghitung jumlah rekomendasi aktif pada suatu kasus.
     */
    public function myRekomendasi($id_kasus)
    {
        return DB::table('kis_rekomendasis as a')
            ->join('kis_temuans as b', function ($join) use ($id_kasus) {
                $join->on('b.id_temuan', '=', 'a.id_temuan')
                    ->where('b.id_kasus', '=', $id_kasus);
            })
            ->whereNull('a.deleted_by')
            ->whereNull('b.deleted_by')
            ->count();
    }

    /**
     * Menghitung jumlah tindak lanjut aktif pada suatu kasus.
     */

    public function myTindakLanjut($id_kasus, $id_status = false)
    {
        $tabelVerifikasi = (new VerifikasiSsr())->getTable();

        $query = DB::table('kis_tindak_lanjuts as a')
            ->join('kis_rekomendasis as b', 'b.id_rekomendasi', '=', 'a.id_rekomendasi')
            ->join('kis_temuans as c', function ($join) use ($id_kasus) {
                $join->on('c.id_temuan', '=', 'b.id_temuan')
                    ->where('c.id_kasus', '=', $id_kasus);
            });

        if ($id_status) {
            $query->whereExists(function ($subQuery) use ($id_status, $tabelVerifikasi) {
                $subQuery->select(DB::raw(1))
                    ->from($tabelVerifikasi . ' as v')
                    ->whereColumn('v.id_tindak_lanjut', 'a.id_tindak_lanjut')
                    ->where('v.id_status', $id_status)
                    ->whereRaw(
                        'v.id = (
                        SELECT MAX(v2.id)
                        FROM ' . $tabelVerifikasi . ' as v2
                        WHERE v2.id_tindak_lanjut = a.id_tindak_lanjut
                    )'
                    );
            });
        }

        return $query
            ->whereNull('a.deleted_by')
            ->whereNull('b.deleted_by')
            ->whereNull('c.deleted_by')
            ->count();
    }
}
