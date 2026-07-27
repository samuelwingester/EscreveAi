<?php

namespace Database\Seeders;

use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::factory()->withTeacher()->count(10)->create();
    }

    public static function seed( ProgressBar $bar, int $count, Collection $teachers, int $min = 3, int $max = 5 ): Collection
    {
        $buffer = collect();

        foreach ( $teachers as $teacher ) {
            if ( $count <= 0 ) break;

            $total = min( $count, fake()->numberBetween( $min, $max ) );

            $count -= $total;

            $buffer = $buffer->concat( Classroom::factory()->for( $teacher )->count( $total )->create() );

            $bar->advance();
        }

        return $buffer;
    }
}
