<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run()
    {
        $horarios = [
            [
                'especialista_id' => 1, // Asegúrate que exista este ID
                'fecha' => now()->format('Y-m-d'),
                'hora' => '09:00:00'
            ],
            [
                'especialista_id' => 1,
                'fecha' => now()->format('Y-m-d'),
                'hora' => '10:00:00'
            ]
        ];

        foreach ($horarios as $horario) {
            Horario::create($horario);
        }
    }
}