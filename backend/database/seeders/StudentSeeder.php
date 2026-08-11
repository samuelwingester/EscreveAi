<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Collection;

use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory()->withClassroom()->count(10)->create();
    }

    public static function seed( ProgressBar $bar, int $count, Collection $classrooms, int $min = 5, int $max = 10 ) : Collection
    {
        $buffer = collect();

        foreach ( $classrooms as $classroom ) {
            if ( $count <= 0 ) break;

            $total = min( $count, fake()->numberBetween( $min, $max ) );

            $count -= $total;

            $buffer = $buffer->concat( Student::factory()->for( $classroom )->count( $total )->create() );

            $bar->advance( $total );
        }

        return $buffer;
    }
}
