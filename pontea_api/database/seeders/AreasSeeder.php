<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $areas = [
            'O eu, o outro e o nós',
            'Corpo, gestos e movimentos',
            'Traços, sons, cores e formas',
            'Escuta, fala, pensamento e imaginação',
            'Espaços, tempos, quantidades, relações e transformações',
        ];

        foreach ($areas as $areaTitle) {
            // Verifique se a área já existe na tabela
            $existingArea = Area::where('title', $areaTitle)->first();

            // Se a área não existir, crie-a
            if (!$existingArea) {
                Area::create([
                    'title' => $areaTitle,
                ]);
            }
        }
    }
}
