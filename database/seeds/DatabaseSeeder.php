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
        $this->call(NGStatesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MeasurementsTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
