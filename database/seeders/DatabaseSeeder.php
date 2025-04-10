<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Client;
use App\Models\User;
use App\Models\AdminSettings;

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
        Role::insert(['name' => 'Aucune']);

        User::create(['name' => 'Administrateur', 'password' => '$2y$10$xpr8uG4INjv7jeQ5VWqKauKKD6Cgv9Fhe2fXdchADmqLW/ec1rAWO', 'role_id' => 1, 'salt' => '09339f6ec9809811']);
        User::create(['name' => 'Utilisateur1', 'password' => '$2y$10$Khfi6peyB2sKFDZ4uqLbCOJnnWB9M2AL2e1mzoB/ZISTVeBzpCgXa', 'role_id' => 2, 'salt' => '59a68525f111dcb7']);
        User::create(['name' => 'Utilisateur2', 'password' => '$2y$10$x8D39qkvqNHu98ekSA4/U.FJwXFAE8hGBphhehrszinjXBHoCrusS', 'role_id' => 3, 'salt' => 'e9b1110a8d2de33d']);

        Client::insert(['first_name' => 'A', 'last_name' => 'AAResident', 'type' => 'Residentiel']);
        Client::insert(['first_name' => 'B', 'last_name' => 'BBResident', 'type' => 'Residentiel']);
        Client::insert(['first_name' => 'C', 'last_name' => 'CCAffaire', 'type' => 'Affaire']);
        Client::insert(['first_name' => 'D', 'last_name' => 'DDAffaire', 'type' => 'Affaire']);
        
        AdminSettings::insert(['attempts' => 3, 'old_passes' => 3, 'capitals' => false, 'special_chars' => false, 'numbers' => false, 'length' => 4]);
        // \App\Models\User::factory(10)->create();
    }
}
