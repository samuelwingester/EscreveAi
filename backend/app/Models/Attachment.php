<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

use App\Enums\DiskType;
use App\Enums\StorageType;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = [
        'user_id',
        'file_name',
        'file_extension',
        'file_path',
        'disk_type',
        'storage_type', // Parando pra pensar esse nome e ruim. tenho que trocar
    ];

    protected function casts(): array
    {
        return [
            'disk_type' => DiskType::class,
            'storage_type' => StorageType::class
        ];
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo( User::class, 'user_id' );
    }
}
