<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Enums\DiskType;
use App\Enums\StorageType;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = [
        'file_name',
        'file_extension',
        'file_path',
        'disk_type',
        'storage_type',
    ];

    protected function casts(): array
    {
        return [
            'disk_type' => DiskType::class,
            'storage_type' => StorageType::class
        ];
    }

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
    //--------------------------------------------------------
}
