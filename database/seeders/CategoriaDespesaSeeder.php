<?php

namespace Database\Seeders;

use Database\Factories\CategoriaDespesaFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaDespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategoriaDespesaFactory::new()->count(5)->create();
    }
}
