<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\User;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function about()
    {
        return Inertia::render('About');
    }

    public function legal()
    {
        return Inertia::render('Legal');
    }

    public function privacy()
    {
        return Inertia::render('Privacy');
    }

    public function help()
    {
        return Inertia::render('Help');
    }

    public function rankings()
    {
        return Inertia::render('Rankings');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        $category_id = $request->get('category_id', null);

        $results = [
            'musics' => [],
            'playlists' => [],
            'artists' => [],
            'query' => $query,
            'category' => $category,
            'category_id' => $category_id
        ];

        if (!empty($query)) {
            // Recherche hiérarchisée
            $results = $this->performHierarchicalSearch($query, $category, $category_id);
        }

        return Inertia::render('Search', $results);
    }

    private function performHierarchicalSearch($query, $category = '', $category_id = null)
    {
        $results = [
            'musics' => [],
            'playlists' => [],
            'artists' => [],
            'query' => $query,
            'category' => $category,
            'category_id' => $category_id
        ];

        // 1. Musiques (toutes celles qui contiennent la recherche)
        $musics = Music::with(['user', 'genres'])
            ->where('title', 'LIKE', '%' . $query . '%')
            ->where('is_public', true)
            ->where('is_approved', true)
            ->when($category_id, function ($q) use ($category_id) {
                return $q->whereHas('genres', function ($subQ) use ($category_id) {
                    $subQ->where('music_genres.id', $category_id);
                });
            })
            ->orderBy('views', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($music) {
                $music->likes_count = $music->likes()->count();
                return $music;
            });

        // 2. Playlists publiques
        $playlists = Playlist::with(['user'])
            ->where('name', 'LIKE', '%' . $query . '%')
            ->where('is_public', true)
            ->withCount('musics')
            ->orderBy('musics_count', 'desc')
            ->limit(10)
            ->get();

        // 3. Artistes (tous ceux qui contiennent la recherche)
        $artists = User::where('name', 'LIKE', '%' . $query . '%')
            ->whereHas('musics', function ($q) {
                $q->where('is_public', true)->where('is_approved', true);
            })
            ->when($category_id, function ($q) use ($category_id) {
                return $q->whereHas('musics.genres', function ($subQ) use ($category_id) {
                    $subQ->where('music_genres.id', $category_id);
                });
            })
            ->withCount([
                'musics' => function ($q) {
                    $q->where('is_public', true)->where('is_approved', true);
                }
            ])
            ->orderBy('musics_count', 'desc')
            ->limit(10)
            ->get();

        $results['musics'] = $musics;
        $results['playlists'] = $playlists;
        $results['artists'] = $artists;

        return $results;
    }
}
