<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasterMonthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_month')->insert([
        [
            'id' => 1,
            'month_number' => '01',
            'month_name' => 'Jan',
        ],
        [
            'id' => 2,
            'month_number' => '02',
            'month_name' => 'Feb',
        ],
        [
            'id' => 3,
            'month_number' => '03',
            'month_name' => 'Mar',
        ],
        [
            'id' => 4,
            'month_number' => '04',
            'month_name' => 'Apr',
        ],
        [
            'id' => 5,
            'month_number' => '05',
            'month_name' => 'May',
        ],
        [
            'id' => 6,
            'month_number' => '06',
            'month_name' => 'Jun',
        ],
        [
            'id' => 7,
            'month_number' => '07',
            'month_name' => 'Jul',
        ],
        [
            'id' => 8,
            'month_number' => '08',
            'month_name' => 'Aug',
        ],
        [
            'id' => 9,
            'month_number' => '09',
            'month_name' => 'Sep',
        ],
        [
            'id' => 10,
            'month_number' => '10',
            'month_name' => 'Okt',
        ],
        [
            'id' => 11,
            'month_number' => '11',
            'month_name' => 'Nov',
        ],
        [
            'id' => 12,
            'month_number' => '12',
            'month_name' => 'Dec',
        ]
        ]);
    }
}