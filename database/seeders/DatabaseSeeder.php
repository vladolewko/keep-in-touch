<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserSubscription;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        User::factory(35)->create();
//        Publication::factory(50)->create(['user_id' => fn() => User::all()->random()->id,]);
        UserSubscription::factory(250)->create([
            'user_id' => fn() => User::all()->random()->id,
            'subscribed_to_id' => fn() => User::all()->random()->id,
        ]);
    }
}
