<?php

namespace Database\Seeders;

use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Collection;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
    }

    public static function seed( ProgressBar $bar, int $count ) : Collection
    {
        $buffer = collect();

        for ( $i = 0; $i < $count; $i++ ) 
        {
            $buffer->push( Teacher::factory()->create() );
        
            $bar->advance();
        }

        return $buffer;
    }
}
