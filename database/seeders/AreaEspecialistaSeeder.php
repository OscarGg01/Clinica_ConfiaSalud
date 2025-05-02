<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Especialista;

class AreaEspecialistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $odontologia = Area::create(['nombre' => 'Odontología']);
        $cardio      = Area::create(['nombre' => 'Cardiología']);
        $pediatria   = Area::create(['nombre' => 'Pediatría']);

        Especialista::create(['area_id' => $odontologia->id, 'nombre' => 'Dra. Pérez']);
        Especialista::create(['area_id' => $odontologia->id, 'nombre' => 'Dr. Gómez']);
        Especialista::create(['area_id' => $cardio->id,    'nombre' => 'Dr. Ruiz']);
        Especialista::create(['area_id' => $pediatria->id, 'nombre' => 'Dra. Luna']);
    }
}
