<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'user_id',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected $appends = [
        'cover_image_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function musics()
    {
        return $this->belongsToMany(Music::class, 'playlist_music');
    }

    /**
     * Obtenir l'URL de l'image de cover avec fallback
     */
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return $this->cover_image;
        }

        // Retourner null pour utiliser l'icône par défaut dans le frontend
        return null;
    }
}
