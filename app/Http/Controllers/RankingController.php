<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function getRankings()
    {
        // Classement des meilleures musiques (score = likes/vues)
        $topTracks = Music::with(['user', 'genres'])
            ->withCount('likes')
            ->where('views', '>', 0) // Éviter la division par zéro
            ->get()
            ->map(function ($music) {
                // Calculer le ratio likes/vues
                $music->score = $music->views > 0 ? round($music->likes_count / $music->views, 3) : 0;
                // Utiliser l'accesseur pour formater le chemin de l'image de cover
                $music->cover_image_url = $music->cover_image_url;
                return $music;
            })
            ->sortByDesc('score')
            ->take(10)
            ->values();

        // Classement des meilleurs artistes (ratio total likes/vues de toutes leurs musiques)
        $topArtists = User::withCount('musics')
            ->whereHas('musics', function ($query) {
                $query->where('views', '>', 0); // Seulement les artistes avec des vues
            })
            ->get()
            ->map(function ($user) {
                // Récupérer toutes les musiques de l'artiste avec leurs statistiques
                $musics = $user->musics()->withCount('likes')->get();
                
                $totalLikes = $musics->sum('likes_count');
                $totalViews = $musics->sum('views');
                
                $user->total_likes = $totalLikes;
                $user->total_views = $totalViews;
                $user->musics_count = $musics->count();
                
                // Calculer le ratio total likes/vues
                $user->score = $totalViews > 0 ? round($totalLikes / $totalViews, 3) : 0;
                
                return $user;
            })
            ->filter(function ($user) {
                return $user->total_views > 0; // Filtrer les artistes sans vues
            })
            ->sortByDesc('score')
            ->take(10)
            ->values();

        return response()->json([
            'success' => true,
            'topTracks' => $topTracks,
            'topArtists' => $topArtists,
            'description' => [
                'tracks' => 'Classement basé sur le ratio likes/vues de chaque musique',
                'artists' => 'Classement basé sur le ratio total likes/vues de toutes les musiques de l\'artiste'
            ]
        ]);
    }
}
