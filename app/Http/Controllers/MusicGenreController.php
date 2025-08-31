<?php

namespace App\Http\Controllers;

use App\Models\MusicGenre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MusicGenreController extends Controller
{
    public function index()
    {
        $genres = MusicGenre::root()
            ->with(['children.children'])
            ->active()
            ->ordered()
            ->get();

        return Inertia::render('Genres/Index', [
            'genres' => $genres
        ]);
    }

    public function show($slug)
    {
        $genre = MusicGenre::where('slug', $slug)
            ->with(['children', 'musics.user', 'musics.genres'])
            ->active()
            ->firstOrFail();

        // Récupérer les musiques de ce genre et de ses sous-genres
        $genreIds = collect([$genre->id])->merge($genre->getAllDescendants()->pluck('id'));

        $musics = \App\Models\Music::whereHas('genres', function ($query) use ($genreIds) {
            $query->whereIn('music_genres.id', $genreIds);
        })
            ->with(['user', 'genres'])
            ->withCount('likes')
            ->approved()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Genres/Show', [
            'genre' => $genre,
            'musics' => $musics
        ]);
    }

    public function getGenres()
    {
        $genres = MusicGenre::root()
            ->with(['children.children'])
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'genres' => $genres
        ]);
    }

    public function getSubGenres($parentId)
    {
        $subGenres = MusicGenre::where('parent_id', $parentId)
            ->active()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'subGenres' => $subGenres
        ]);
    }
}
