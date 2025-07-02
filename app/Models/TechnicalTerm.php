<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalTerm extends Model
{
    protected $fillable = [
        'term',
        'definition_en',
        'definition_id',
        'category',
        'usage_example',
        'pronunciation'
    ];

    protected $casts = [
        'usage_example' => 'array'
    ];
} 