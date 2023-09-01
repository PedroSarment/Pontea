<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;


class LevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $levels = [
            'nivel 1',
            'nivel 2',
            'nivel 3',
        ];

        foreach ($levels as $levelTitle) {
            // Verifique se o nível já existe na tabela
            $existingLevel = Level::where('title', $levelTitle)->first();

            // Se o nível não existir, crie-o
            if (!$existingLevel) {
                Level::create([
                    'title' => $levelTitle,
                ]);
            }
        }
    }
}
