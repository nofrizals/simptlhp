<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kis_tims')->insert([
            [
                'id' => 1,
                'name' => 'TLHP TIM I',
                'nip_ketua' => '197609292000031004',
                'created_by' => '197601312007011004',
                'created_at' => '2022-01-25 09:36:46',
                'edited_by' => '197601312007011004',
                'edited_at' => '2022-11-02 11:50:25',
                'deleted_by' => NULL,
                'deleted_at' => NULL
            ],
            [
                'id' => 2,
                'name' => 'TLHP TIM II',
                'nip_ketua' => '197206241992011002',
                'created_by' => '197601312007011004',
                'created_at' => '2022-01-25 09:50:55',
                'edited_by' => NULL,
                'edited_at' => NULL,
                'deleted_by' => NULL,
                'deleted_at' => NULL
            ],
            [
                'id' => 3,
                'name' => 'TLHP TIM III',
                'nip_ketua' => '196705071990031001',
                'created_by' => '197601312007011004',
                'created_at' => '2022-01-25 09:57:25',
                'edited_by' => '197601312007011004',
                'edited_at' => '2023-10-26 11:05:39',
                'deleted_by' => NULL,
                'deleted_at' => NULL
            ],
            [
                'id' => 4,
                'name' => 'TLHP TIM IV',
                'nip_ketua' => '197304292000031003',
                'created_by' => '197601312007011004',
                'created_at' => '2022-01-25 09:57:39',
                'edited_by' => NULL,
                'edited_at' => NULL,
                'deleted_by' => NULL,
                'deleted_at' => NULL
            ],
            [
                'id' => 5,
                'name' => 'TLHP TIM V',
                'nip_ketua' => '197312092003122003',
                'created_by' => '197601312007011004',
                'created_at' => '2022-01-25 09:57:51',
                'edited_by' => '197601312007011004',
                'edited_at' => '2023-05-19 10:46:41',
                'deleted_by' => NULL,
                'deleted_at' => NULL
            ]
        ]);
    }
}
