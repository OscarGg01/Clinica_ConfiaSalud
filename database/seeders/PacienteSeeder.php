<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paciente::create([
            'dni'              => '72350753',
            'apellido_paterno' => 'Gonzales',
            'apellido_materno' => 'Garcia',
            'nombres'          => 'Oscar Antonio',
            'fecha_nac'        => '2002-07-01',
            'sexo'             => 'Masculino',
            'email'            => '72350753@continental.edu.pe',
            'telefono'         => '923813488',
            'whatsapp'         => '923813488',
            'ubicacion'        => 'Jr. Junín 1822, El Tambo',
        ]);
    }
}
