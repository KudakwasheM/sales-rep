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
            'username' => 'super',
            'email' => 'super@sales.com',
            'phone' => '+263123123123',
            'role_id' => 1,
            'password' => bcrypt('Super313'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@sales.com',
            'phone' => '+263123123124',
            'role_id' => 2,
            'password' => bcrypt('Admin313'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sale Rep',
            'username' => 'sales',
            'email' => 'sales@sales.com',
            'phone' => '+263123123124',
            'role_id' => 3,
            'password' => bcrypt('Sales313'),
        ]);

        \App\Models\Client::factory()->create([
            'name' => 'Kudakwashe Masaya',
            'id_number' => '59-174530T34',
            'dob' => '1996-12-10',
            'ec_number' => '5143',
            'type' => 'v_mum_usd',
            'battery_number' => '123456789',
            'created_by' => 'super',
        ]);
    }
}
