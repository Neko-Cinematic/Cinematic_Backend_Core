<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $date = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(); // get datetime now // get datetime now  // get datetime now
        DB::table('authors')->delete();
        DB::table('authors')->truncate();
        DB::table('authors')->insert([
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Na Young-seok',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Jang Eun-jung',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Trâu Hi',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Chu Tĩnh Thao',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Sam Hargrave',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
