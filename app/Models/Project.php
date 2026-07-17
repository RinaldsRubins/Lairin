<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client',
        'industry',
        'image',
        'gallery',
        'technologies',
        'is_featured',
        'is_published',
        'sort_order',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'technologies' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }
}
