<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('sql/blogs.sql');
        $sql = file_get_contents($path);
        DB::connection()->getPdo()->exec($sql);
    }
}
