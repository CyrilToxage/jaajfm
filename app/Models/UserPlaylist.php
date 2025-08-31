<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_public',
        'cover_image',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les musiques de la playlist
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(PlaylistTrack::class)->orderBy('position');
    }

    /**
     * Relation avec les musiques (via PlaylistTrack)
     */
    public function musicTracks()
    {
        return $this->belongsToMany(Music::class, 'playlist_tracks', 'playlist_id', 'music_id')
            ->withPivot('position')
            ->orderBy('playlist_tracks.position');
    }

    /**
     * Scope pour les playlists publiques
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Obtenir le nombre de musiques dans la playlist
     */
    public function getTracksCountAttribute(): int
    {
        return $this->tracks()->count();
    }
}
