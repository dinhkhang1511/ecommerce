<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('sql/wards.sql');
        $sql = file_get_contents($path);
        DB::connection()->getPdo()->exec($sql);
    }
}
