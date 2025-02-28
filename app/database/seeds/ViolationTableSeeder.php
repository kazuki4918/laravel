<?php

use Illuminate\Database\Seeder;

class ViolationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Violation::class, 10)->create();
    }
}
