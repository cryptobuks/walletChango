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
         $this->call(UsersSeeder::class);
         $this->call(GroupSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(GroupMemebershipSeeder::class);
    }
}
