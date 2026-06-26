<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\TurmaSeeder;
use Database\Seeders\ProfessorSeeder;
use Database\Seeders\ResponsavelSeeder;
use Database\Seeders\AlunoSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            ProfessorSeeder::class,
            ResponsavelSeeder::class,
            TurmaSeeder::class,
            AlunoSeeder::class
        ]);
    }
}
