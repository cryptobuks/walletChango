<?php

use App\wallet;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create()->each(function ($user) {
            $user->wallet()->save(factory(Wallet::class)->make());
        });
    }


}
