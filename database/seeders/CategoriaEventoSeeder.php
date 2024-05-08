<?php

namespace Database\Seeders;

use App\Models\CategoriaEvento;
use Database\Factories\CategoriaEventoFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CategoriaEventoFactory::new()->count(5)->create();
    }
}
