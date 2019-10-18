<?php

use App\Group;
use App\Payments_;
use App\Projects;
use App\User;
use App\wallet;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => "Abednego Kilonzo",
        'email' => "abedxh@gmail.com",
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'wallet_name' => $faker->company,
        'wallet_amount' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->define(Group::class, function (Faker $faker) {
    return [
        'group_name' => $faker->company,
        'created_at' => now(),
        'updated_at' => now(),
        'group_uuid' => $faker->uuid,
    ];
});
$factory->define(Projects::class, function (Faker $faker) {
    return [
        'project_name' => $faker->name,
        'project_description' => $faker->realText(),
        'image_url' => $faker->randomElement(['crowd_fund.jpg', 'crowd_fund2.jpg'
            , 'crowd_fund3.jpg', 'crowd_fund4.jpg', 'crowd_fund5.jpg', 'crowd_fund6.jpg', 'fund.png']),
        'project_details' => $faker->realText(),
        'target_group_number' => $faker->numberBetween($min = 1, $max = 20),
        'project_target_amount' => $faker->numberBetween(100, 1000),
        'members_subscribed' => $faker->numberBetween(5, 15),
        'project_initiated_by' => App\User::all()->random()->id,
        'amount_collected' => $faker->numberBetween(100, 600),
        'project_type' => $faker->numberBetween(1, 2),
        'group_id' => App\Group::all()->random()->id,
        'updated_at' => now(),
        'created_at' => now(),
    ];
});

$factory->define(Payments_::class, function (Faker $faker) {
    return [
        'payment_reference' => $faker->name,
        'payment_amount' => $faker->numberBetween(100, 600),
        'user_id' => App\User::all()->random()->id,
        'project_id' => App\Projects::all()->random()->id,
//        'group_id' => App\Group::all()->random()->id,
        'updated_at' => $faker->dateTimeThisYear(),
        'created_at' => $faker->dateTimeThisYear(),
    ];
});
$factory->define(\App\GroupMembership::class, function (Faker $faker) {
    return [
        'group_id' => App\Group::all()->random()->id,
        'user_id' =>App\User::all()->random()->id,
    ];
});
