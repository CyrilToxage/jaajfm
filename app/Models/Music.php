<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\MusicComment;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'cover_image',
        'file_size',
        'duration',
        'views',
        'user_id',
        'is_public',
        'is_approved',
        'status',
        'is_ai_generated',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_public' => 'boolean',
        'is_ai_generated' => 'boolean',
        'duration' => 'integer',
        'views' => 'integer',
        'file_size' => 'integer',
    ];

    protected $appends = [
        'comments_count',
        'views_count',
        'cover_image_url'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(MusicComment::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(MusicView::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_music');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MusicGenre::class, 'music_genre', 'music_id', 'music_genre_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Accesseur pour le nombre de likes
    public function getLikesCountAttribute()
    {
        // Si la relation est déjà chargée, utiliser count()
        if ($this->relationLoaded('likes')) {
            return $this->likes->count();
        }
        // Sinon, faire une requête
        return $this->likes()->count();
    }

    // Accesseur pour le nombre de commentaires
    public function getCommentsCountAttribute()
    {
        // Si la relation est déjà chargée, utiliser count()
        if ($this->relationLoaded('comments')) {
            return $this->comments->count();
        }
        // Sinon, faire une requête
        return $this->comments()->count();
    }

    // Accesseur pour le nombre de vues
    public function getViewsCountAttribute()
    {
        // Si la relation est déjà chargée, utiliser count()
        if ($this->relationLoaded('views')) {
            return $this->views->count();
        }
        // Sinon, faire une requête
        return $this->views()->count();
    }

    // Accesseur pour formater le chemin de l'image de cover
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

        // Sinon, ajouter /storage/uploads/covers/ par défaut
        return '/storage/uploads/covers/' . $this->cover_image;
    }

    // Générer un slug unique basé sur le titre
    public static function generateSlug($title)
    {
        $baseSlug = \Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        // Vérifier si le slug existe déjà
        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    // Boot method pour générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($music) {
            if (empty($music->slug)) {
                $music->slug = static::generateSlug($music->title);
            }
        });

        static::updating(function ($music) {
            if ($music->isDirty('title') && empty($music->slug)) {
                $music->slug = static::generateSlug($music->title);
            }
        });
    }
}
