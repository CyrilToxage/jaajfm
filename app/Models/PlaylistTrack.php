<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaylistTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'music_id',
        'order',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    /**
     * Relation avec la playlist
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(UserPlaylist::class, 'playlist_id');
    }

    /**
     * Relation avec la musique
     */
    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class);
    }
}
