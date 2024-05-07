<?php

namespace Database\Seeders;

use Database\Factories\EventoFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        EventoFactory::new()->count(15)->create();
    }
}
