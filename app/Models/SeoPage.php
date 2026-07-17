<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $fillable = [
        'path',
        'title',
        'description',
        'keywords',
        'og_image',
        'schema_markup',
    ];

    protected function casts(): array
    {
        return [
            'schema_markup' => 'array',
        ];
    }
}
