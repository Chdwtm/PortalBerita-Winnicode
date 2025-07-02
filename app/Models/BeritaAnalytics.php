<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaAnalytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'views',
        'device',
        'source',
        'user_age_range',
        'avg_time_on_page',
        'bounce_rate'
    ];

    protected $casts = [
        'keywords_extracted' => 'array',
        'sentiment_score' => 'float',
        'engagement_score' => 'float',
        'popularity_score' => 'float',
        'click_through_rate' => 'float',
        'bounce_rate' => 'float'
    ];

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }
} 