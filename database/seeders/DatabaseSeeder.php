<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Super User',
            'username' => 'super313',
            'ec_number' => 'EC00001',
            'email' => 'super@sales.com',
            'phone' => '+263123123123',
            'role_id' => 1,
            'password' => bcrypt('Super313'),
        ]);
    }
}
