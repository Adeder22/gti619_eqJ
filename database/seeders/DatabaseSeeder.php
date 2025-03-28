<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Client;
use App\Models\User;

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

        User::insert(['name' => 'Administrateur', 'password' => 'admin123', 'role_id' => 1]);
        User::insert(['name' => 'Utilisateur 1', 'password' => 'user1', 'role_id' => 2]);
        User::insert(['name' => 'Utilisateur 2', 'password' => 'user2', 'role_id' => 3]);

        Client::insert(['first_name' => 'A', 'last_name' => 'AAResident', 'type' => 'Residentiel']);
        Client::insert(['first_name' => 'B', 'last_name' => 'BBResident', 'type' => 'Residentiel']);
        Client::insert(['first_name' => 'C', 'last_name' => 'CCAffaire', 'type' => 'Affaire']);
        Client::insert(['first_name' => 'D', 'last_name' => 'DDAffaire', 'type' => 'Affaire']);
        
        // \App\Models\User::factory(10)->create();
    }
}
