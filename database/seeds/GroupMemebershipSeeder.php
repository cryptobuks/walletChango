<?php

use Illuminate\Database\Seeder;

class GroupMemebershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\GroupMembership::class, 5)->create();
    }
}
