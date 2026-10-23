<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\StorageType;
use App\Enums\DiskType;
use App\Models\Attachment;
use App\Models\Activity;

/**
 * @extends Factory<Attachment>
 */
class AttachmentFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition() : array
    {
        return [
            'file_name' => fake()->word() . '.pdf',
            'file_mime' => 'application/pdf',
            'file_path' => fake()->filePath(),
            'storage_type' => StorageType::LOCAL,
            'disk_type'    => DiskType::TESTING,
        ];
    }

    public function forActivity() : static
    {
        return $this->for(
            Activity::factory()->withClassroom(),
            'attachable'
        );
    }

    // NT: Imlementar funcoes de 'for Model' para as models que tiverem anexos
    // para quando tiverem suas factories
}
