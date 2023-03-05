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

        \App\Models\Role::factory()->create([
            'name' => 'Super',
            'slug' => 'superuser',
            'description' => 'This is a super user',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'adminuser',
            'description' => 'This is an admin user',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Administration',
            'slug' => 'administrationuser',
            'description' => 'This is a sdministration user',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'SalesRep',
            'slug' => 'salesrepuser',
            'description' => 'This is a sales representative user',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Super User',
            'username' => 'super313',
            'ec_number' => 'EC00001',
            'email' => 'super@sales.com',
            'phone' => '+263123123123',
            'password' => bcrypt('Super313'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin313',
            'ec_number' => 'EC00002',
            'email' => 'admin@sales.com',
            'phone' => '+263123123124',
            'password' => bcrypt('Admin313'),
        ]);
    }
}
