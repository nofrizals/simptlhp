<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class StatusKasusService
{
    protected $hitung;

    public function __construct(HitungService $hitung)
    {
        $this->hitung = $hitung;
    }

    public function update($id_kasus, $turn_to_unfinish = false)
    {
        if ($turn_to_unfinish) {

            $data = [
                'selesai' => '0'
            ];
        } else {

            $rekomendasi = $this->hitung->myRekomendasi($id_kasus);

            $tindak_lanjut = $this->hitung->myTindakLanjut($id_kasus, 1);

            if ($rekomendasi && ($rekomendasi - $tindak_lanjut == 0)) {

                $data = [
                    'selesai' => '1'
                ];
            } else {

                $data = [
                    'selesai' => '0'
                ];
            }
        }

        $kasus = DB::table('kis_kasus')
            ->where('id_kasus', $id_kasus);

        if (!$kasus->exists()) {
            return false;
        }

        $kasus->update($data);

        return true;
    }
}
