<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::insert(['name' => 'Administrateur']);
        Role::insert(['name' => 'Préposé aux clients résidentiels']);
        Role::insert(['name' => 'Préposé aux clients d’affaire']);

        Client::insert(['name' => 'Administrateur', 'password' => 'admin123', 'role_id' => 1]);
        Client::insert(['name' => 'Utilisateur 1', 'password' => 'user1', 'role_id' => 2]);
        Client::insert(['name' => 'Utilisateur 2', 'password' => 'user2', 'role_id' => 3]);

        // \App\Models\User::factory(10)->create();
    }
}
