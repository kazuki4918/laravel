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
        //$this->call(UserTableSeeder::class);
        //$this->call(PostTableSeeder::class);
        $this->call(RequestTableSeeder::class);
        $this->call(ViolationTableSeeder::class);
    }
}
