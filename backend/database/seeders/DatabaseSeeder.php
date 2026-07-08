<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $buffer_1 = [];
        $buffer_2 = [];

        $count = fake()->numberBetween(20, 50);

        $this->command->info('Criando ' . $count . ' Professores');
        $bar = $this->command->getOutput()->createProgressBar( $count );
        $bar->start();
        for ( $i = 0; $i < 10; $i++ ) {
            $buffer_1[] = Teacher::factory()->create();
        
            $bar->advance();
        }
        $bar->finish();

        $count = count( $buffer_1 ) * 3;

        $this->command->newLine();
        $this->command->info('Criando ' . $count . 'Turmas');
        $bar = $this->command->getOutput()->createProgressBar( $count );
        $bar->start();
        foreach ( $buffer_1 as $teacher ) {
            $total = 0;

            if ( $count <= 5 ) $total = $count;
            else $total = fake()->numberBetween(3, 5);

            $count -= $total;

            for ( $i = 0; $i < $total; $i++ ) { 
                $buffer_2[] = Classroom::factory()->for( $teacher )->create();

                $bar->advance();
            }
        }
        $bar->finish();

        $count = count( $buffer_2 ) * 50;

        $this->command->newLine();
        $this->command->info('Criando ' . $count . 'Alunos');
        $bar = $this->command->getOutput()->createProgressBar( $count );
        $bar->start();
        foreach ( $buffer_2 as $classroom ) {
            $total = 0;

            if ( $count <= 50 ) $total = $count;
            else $total = fake()->numberBetween(20, 50);

            $count -= $total;

            for ( $i = 0; $i < $total; $i++ ) { 
                Student::factory()->for( $classroom )->create();

                $bar->advance();
            }
        }
        $bar->finish();

        /*
        $this->call([
            Teacher::factory()
                ->count( fake()->numberBetween(20, 50) )->create()
                ->each( function ( Teacher $teacher ){
                    Classroom::factory()
                        ->count( fake()->numberBetween(2, 5) )->for( $teacher )->create()
                        ->each( function ( Classroom $classroom ){
                            Student::factory()
                                ->count( fake()->numberBetween(20, 50) )->for( $classroom )->create();
                        });
                })
        ]);
        */
    }
}
