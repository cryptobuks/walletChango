<?php

use Illuminate\Database\Seeder;

class ChamaaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Chamaa::class, 15)->create();

    }
}
