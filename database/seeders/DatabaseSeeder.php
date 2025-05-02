<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// Importa tu seeder de áreas y especialistas
use Database\Seeders\AreaEspecialistaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PacienteSeeder::class);
    }
}
