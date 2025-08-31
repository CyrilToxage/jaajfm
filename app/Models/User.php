<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relation avec les musiques de l'utilisateur
     */
    public function musics(): HasMany
    {
        return $this->hasMany(Music::class);
    }

    /**
     * Relation avec les likes de l'utilisateur
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relation avec les commentaires de l'utilisateur
     */
    public function musicComments(): HasMany
    {
        return $this->hasMany(MusicComment::class);
    }

    /**
     * Relation avec les posts de l'utilisateur
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relation avec les commentaires de posts de l'utilisateur
     */
    public function postComments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     * Relation avec les playlists de l'utilisateur
     */
    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Relation avec les abonnements (utilisateurs suivis)
     */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Relation avec les utilisateurs que cet utilisateur suit
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Relation avec les utilisateurs qui suivent cet utilisateur
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Vérifier si l'utilisateur suit un autre utilisateur
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Vérifier si l'utilisateur est suivi par un autre utilisateur
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Obtenir le nombre de followers
     */
    public function getFollowersCountAttribute(): int
    {
        return $this->followers()->count();
    }

    /**
     * Obtenir le nombre d'utilisateurs suivis
     */
    public function getFollowingCountAttribute(): int
    {
        return $this->following()->count();
    }

    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Relation avec les signalements créés par l'utilisateur
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * Relation avec les signalements résolus par l'utilisateur (admin)
     */
    public function resolvedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'resolved_by');
    }

    /**
     * Accesseur pour le nombre de commentaires
     */
    public function getMusicCommentsCountAttribute(): int
    {
        return $this->musicComments()->count();
    }

}
