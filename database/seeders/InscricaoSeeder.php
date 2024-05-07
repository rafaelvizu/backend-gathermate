<?php

namespace Database\Seeders;

use Database\Factories\InscricaoFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InscricaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        InscricaoFactory::new()->count(5000)->create();
    }
}
