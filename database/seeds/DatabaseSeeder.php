<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SystemSettingSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            RoleUserSeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
            WardSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            ProductSeeder::class,
            ProductAttributeSeeder::class,
            ProductImageSeeder::class,
            TagSeeder::class,
            BlogSeeder::class,
            BlogTagSeeder::class,
            AlbumSeeder::class,
            AlbumImageSeeder::class,
        ]);
    }
}
