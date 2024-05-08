<?php

namespace Database\Seeders;

use Database\Factories\DespesaFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DespesaFactory::new()->count(5000)->create(0);
    }
}
