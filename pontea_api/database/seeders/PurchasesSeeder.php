<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;


class PurchasesSeeder extends Seeder
{
    public function run()
    {
        // Gere compras usando o factory
        Purchase::factory(50)->create();
    }
}
