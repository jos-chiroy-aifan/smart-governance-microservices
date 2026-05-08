<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'original_name',
        'storage_path',
        'size_readable',
        'mime_type',
        'status',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
