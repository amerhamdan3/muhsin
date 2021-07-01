<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2021-06-27 19:07:59',
                'updated_at' => '2021-06-27 19:07:59',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2021-06-27 19:07:59',
                'updated_at' => '2021-06-27 19:07:59',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2021-06-27 19:07:59',
                'updated_at' => '2021-06-27 19:07:59',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
