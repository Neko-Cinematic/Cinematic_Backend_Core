<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(); // get datetime now
        DB::table('employees')->delete();
        DB::table('employees')->truncate();
        DB::table('employees')->insert([
            [
                'name'          => 'Quang Huy',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'quanghuy@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '1 ',
            ],
            [
                'name'          => 'Minh Tuấn',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'minhtuan@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '2',
            ],
            [
                'name'          => 'Văn Trọng',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'vantrong@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '3',
            ],
            [
                'name'          => 'Khánh Trần',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'khanhtran@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '4',
            ],
            [
                'name'          => 'Quốc Triệu',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'quoctrieu@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '5',
            ],
            [
                'name'          => 'Quang Quang',
                'created_at'    => $date,
                'updated_at'    => $date,
                'email'         => 'quangquang@gmail.com',
                'password'      => bcrypt('123'),
                'id_permissons' => '6',
            ],

        ]);
    }
}
