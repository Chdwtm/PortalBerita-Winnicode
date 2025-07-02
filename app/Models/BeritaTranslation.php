<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaTranslation extends Model
{
    protected $fillable = [
        'berita_id',
        'language',
        'title',
        'content',
        'meta_description',
        'keywords'
    ];

    /**
     * Get the berita that owns the translation.
     */
    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }
} 