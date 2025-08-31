<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class MusicGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'parent_id',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Relations
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MusicGenre::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MusicGenre::class, 'parent_id')->orderBy('order');
    }

    public function musics(): BelongsToMany
    {
        return $this->belongsToMany(Music::class, 'music_genre', 'music_genre_id', 'music_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Accesseurs
    public function getIsRootAttribute(): bool
    {
        return is_null($this->parent_id);
    }

    public function getIsChildAttribute(): bool
    {
        return !is_null($this->parent_id);
    }

    public function getFullNameAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->name . ' > ' . $this->name;
        }
        return $this->name;
    }

    public function getAllChildrenAttribute()
    {
        return $this->children()->with('children')->get();
    }

    // Méthodes
    public static function generateSlug($name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getHierarchyLevel(): int
    {
        $level = 0;
        $current = $this;

        while ($current->parent) {
            $level++;
            $current = $current->parent;
        }

        return $level;
    }

    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    public function getAllAncestors()
    {
        $ancestors = collect();
        $current = $this->parent;

        while ($current) {
            $ancestors->prepend($current);
            $current = $current->parent;
        }

        return $ancestors;
    }
}
