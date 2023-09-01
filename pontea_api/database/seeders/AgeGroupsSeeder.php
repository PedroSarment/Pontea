<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgeGroup;


class AgeGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $ageGroups = [
            '0 a 1 ano e 6 meses',
            '1 ano e 7 meses a 3 anos e 11 meses',
            '4 anos a 5 anos e 11 meses',
            '6 anos a 11 anos',
        ];

        foreach ($ageGroups as $ageGroupTitle) {
            // Verifique se o grupo de idade já existe na tabela
            $existingAgeGroup = AgeGroup::where('title', $ageGroupTitle)->first();

            // Se o grupo de idade não existir, crie-o
            if (!$existingAgeGroup) {
                AgeGroup::create([
                    'title' => $ageGroupTitle,
                ]);
            }
        }
    }
}
