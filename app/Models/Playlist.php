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
        if (!$this->cover_image) {
            return null;
        }

        // Si le chemin commence déjà par /storage/, le retourner tel quel
        if (str_starts_with($this->cover_image, '/storage/')) {
            return $this->cover_image;
        }

        // Si le chemin commence par uploads/, ajouter /storage/
        if (str_starts_with($this->cover_image, 'uploads/')) {
            return '/storage/' . $this->cover_image;
        }

        // Si le chemin commence par playlist-covers/, ajouter /storage/
        if (str_starts_with($this->cover_image, 'playlist-covers/')) {
            return '/storage/' . $this->cover_image;
        }

        // Sinon, ajouter /storage/playlist-covers/ par défaut
        return '/storage/playlist-covers/' . $this->cover_image;
    }
}
