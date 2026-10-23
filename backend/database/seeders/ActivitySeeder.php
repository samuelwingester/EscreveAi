<?php

namespace Database\Seeders;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;

use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::factory()->withClassroom()->count(10)->create();
    }

    public static function seed( ProgressBar $bar, int $count, Collection $classrooms, int $min = 1, int $max = 2 ) : Collection
    {
        $buffer = collect();

        foreach ( $classrooms as $classroom ) {
            if ( $count <= 0 ) break;

            $total = min( $count, fake()->numberBetween($min, $max) );

            $count -= $total;

            $buffer = $buffer->concat( Activity::factory()->for( $classroom )->count( $total )->create() );

            $bar->advance( $total );
        }

        return $buffer;
    }
}
