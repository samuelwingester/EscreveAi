<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Record;

class Analysis extends Model
{
    use HasFactory;

    protected $table = 'analyses';

    protected $fillable = [
        'record_id',
        'observations',
        'spelling_errors',
        'mirrored_letters',
        'learning_difficulties'
    ];

    protected function casts(): array
    {
        return [
            'spelling_errors' => 'array',
            'mirrored_letters' => 'array',
            'learning_difficulties' => 'array'
        ];
    }

    public function record()
    {
        return $this->belongsTo( Record::class, 'record_id' );
    }
}
