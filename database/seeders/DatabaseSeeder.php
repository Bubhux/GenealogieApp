<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création de l'utilisateur admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@genealogie.com',
            'password' => bcrypt('password'),
        ]);

        // Exécution des seeders
        $this->call([
            PeopleTableSeeder::class,
            RelationshipsTableSeeder::class,
        ]);
    }
}