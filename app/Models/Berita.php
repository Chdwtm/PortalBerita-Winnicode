<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $judul
 * @property int $kategori_id
 * @property string $konten
 * @property string|null $gambar
 * @property int $penulis_id
 * @property int $views
 */
class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'kategori_id', 'konten', 'gambar', 'penulis_id', 'views', 'user_id'];
    
    // Add accessors for user_reaction
    protected $appends = ['user_reaction', 'likes_count', 'dislikes_count'];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function reactions()
    {
        return $this->hasMany(BeritaReaction::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->reactions()->where('type', 'like')->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->reactions()->where('type', 'dislike')->count();
    }

    public function getUserReactionAttribute()
    {
        if (!auth()->check()) return null;
        return $this->reactions()->where('user_id', auth()->id())->value('type');
    }

    public function analytics()
    {
        return $this->hasOne(BeritaAnalytics::class);
    }
}