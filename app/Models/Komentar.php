<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komentar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['berita_id', 'user_id', 'konten'];
    protected $dates = ['deleted_at'];
    public $timestamps = true; // Pastikan timestamps aktif agar waktu komentar tersimpan otomatis

    // **Relasi ke User**
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // **Relasi ke Berita**
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}