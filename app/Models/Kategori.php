<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 */
class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    // Add accessor for created_at to handle null values
    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value) : now();
    }

    // Add accessor for updated_at to handle null values
    public function getUpdatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value) : now();
    }

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id', 'id'); // Pastikan relasi benar
    }
}