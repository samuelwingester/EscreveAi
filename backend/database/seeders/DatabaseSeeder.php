<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\TeacherSeeder;
use Database\Seeders\ClassroomSeeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        //---------------------------------------------------------
        // Teacher Seeding
        //---------------------------------------------------------
        $count = fake()->numberBetween(20, 30);
        
        $teachers = $this->runSeeder( 
            'Professores', $count, 
            fn( $bar ) => TeacherSeeder::seed( $bar, $count ) 
        );
        //---------------------------------------------------------

        //---------------------------------------------------------
        // Classroom Seeding
        //---------------------------------------------------------
        $count = $teachers->count() * 3;

        $classrooms = $this->runSeeder( 
            'Turmas', $count, 
            fn( $bar ) => ClassroomSeeder::seed( $bar, $count, $teachers ) 
        ); 
        //---------------------------------------------------------

        //---------------------------------------------------------
        // Student Seeding
        //---------------------------------------------------------
        $count = $classrooms->count() * 10;

        $this->runSeeder( 
            'Estudantes', $count, 
            fn( $bar ) => StudentSeeder::seed( $bar, $count, $classrooms ) 
        ); 
        //---------------------------------------------------------

        //---------------------------------------------------------
        // Activity Seeding
        //---------------------------------------------------------
        $count = $classrooms->count() * 2;

        $this->runSeeder( 
            'Atividades', $count, 
            fn( $bar ) => ActivitySeeder::seed( $bar, $count, $classrooms ) 
        ); 
        //---------------------------------------------------------
    }

    private function createBar( string $name, int $count ) : ProgressBar
    {
        $this->command->newLine();
        $this->command->info( 'Criando ' . $count . ' ' . $name );
        $this->command->newLine();

        return $this->command->getOutput()->createProgressBar( $count );
    }

    private function runSeeder( string $name, int $count, callable $callback ) : mixed
    {
        $bar = $this->createBar( $name, $count );

        $bar->start();

        $buffer = $callback( $bar );

        $bar->finish();

        return $buffer;
    }
}
