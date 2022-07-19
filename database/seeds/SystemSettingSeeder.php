<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->insert([
            'shop_name' => 'Adike',
            'site_title' => 'Just Do It',
            'email' => 'thanhphu2410@gmail.com',
            'copyright_text' => '© 2021 Made with ♥ by thanhphu2410@gmail.com'
        ]);
    }
}
