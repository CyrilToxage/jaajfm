<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MusicController extends Controller
{
    public function index()
    {
        // Musiques populaires (avec plus de vues)
        $popularMusics = Music::with(['user', 'genres'])
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($music) {
                $music->likes_count = $music->likes()->count();
                return $music;
            });

        // Musiques récentes
        $recentMusics = Music::with(['user', 'genres'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($music) {
                $music->likes_count = $music->likes()->count();
                return $music;
            });

        // Musiques les plus likées
        $mostLikedMusics = Music::with(['user', 'genres'])
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->limit(10)
            ->get();

        // Tous les genres utilisés sur le site (qui ont des musiques)
        $popularGenres = DB::table('music_genres')
            ->select('music_genres.*', DB::raw('COUNT(music_genre.music_id) as musics_count'))
            ->join('music_genre', 'music_genres.id', '=', 'music_genre.music_genre_id')
            ->groupBy('music_genres.id', 'music_genres.name', 'music_genres.slug', 'music_genres.description', 'music_genres.color', 'music_genres.parent_id', 'music_genres.order', 'music_genres.is_active', 'music_genres.created_at', 'music_genres.updated_at')
            ->orderBy('musics_count', 'desc')
            ->get();

        // Musiques par genre
        $musicsByGenre = [];
        foreach ($popularGenres as $genre) {
            $musicsByGenre[$genre->id] = Music::with(['user', 'genres'])
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('music_genres.id', $genre->id);
                })
                ->where('views', '>', 0)
                ->limit(3)
                ->get()
                ->map(function ($music) {
                    $music->likes_count = $music->likes()->count();
                    $music->comments_count = $music->comments()->count();
                    $music->views_count = $music->views()->count();
                    return $music;
                });
        }

        return Inertia::render('Welcome', [
            'popularMusics' => $popularMusics,
            'recentMusics' => $recentMusics,
            'mostLikedMusics' => $mostLikedMusics,
            'popularGenres' => $popularGenres,
            'musicsByGenre' => $musicsByGenre,
        ]);
    }

    public function show($identifier)
    {
        // Chercher la musique par slug ou ID
        $music = Music::with(['user', 'genres', 'comments.user', 'comments.replies.user'])
            ->where(function ($query) use ($identifier) {
                $query->where('slug', $identifier)
                    ->orWhere('id', $identifier);
            })
            ->firstOrFail();

        // Compter les likes et commentaires
        $music->likes_count = $music->likes()->count();
        $music->comments_count = $music->comments()->count(); // Tous les commentaires (parents + réponses)

        // Vérifier si l'utilisateur connecté a liké cette musique
        $isLiked = false;
        $isFollowing = false;
        if (auth()->check()) {
            $isLiked = $music->likes()->where('user_id', auth()->id())->exists();
            $isFollowing = auth()->user()->following()->where('following_id', $music->user_id)->exists();
        }

        // Récupérer les commentaires avec pagination (seulement les commentaires parents)
        $comments = $music->comments()
            ->whereNull('parent_id') // Seulement les commentaires parents
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($comment) {
                // Pour l'instant, pas de système de likes pour les commentaires
                $comment->likes_count = 0;
                $comment->is_liked = false;

                // Charger les réponses séparément
                $comment->replies = \App\Models\MusicComment::where('parent_id', $comment->id)
                    ->with('user')
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->map(function ($reply) {
                    $reply->likes_count = 0;
                    $reply->is_liked = false;
                    return $reply;
                });

                return $comment;
            });

        // Musiques similaires (même genre)
        $similarTracks = Music::with(['user', 'genres'])
            ->whereHas('genres', function ($query) use ($music) {
                $query->whereIn('music_genres.id', $music->genres->pluck('id'));
            })
            ->where('id', '!=', $music->id)
            ->where('views', '>', 0)
            ->limit(8)
            ->get()
            ->map(function ($track) {
                $track->likes_count = $track->likes()->count();
                return $track;
            });

        return Inertia::render('Music/Show', [
            'music' => $music,
            'comments' => $comments,
            'similarTracks' => $similarTracks,
            'isLiked' => $isLiked,
            'isFollowing' => $isFollowing,
            'hasMoreComments' => $music->comments()->whereNull('parent_id')->count() > 10,
            'isLoadingMore' => false,
        ]);
    }

    public function like(Request $request, $id)
    {
        $music = Music::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $existingLike = $music->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            return response()->json(['success' => true, 'action' => 'unliked']);
        } else {
            // Like
            $music->likes()->create([
                'user_id' => $user->id
            ]);
            return response()->json(['success' => true, 'action' => 'liked']);
        }
    }

    public function view(Request $request, $id)
    {
        $music = Music::findOrFail($id);

        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            // Si l'utilisateur n'est pas connecté, on peut incrémenter la vue
            // mais on ne l'enregistre pas dans analytics
            $music->increment('views');
            return response()->json(['success' => true]);
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur a déjà vu cette musique
        $existingView = DB::table('analytics_music_views')
            ->where('music_id', $music->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingView) {
            // L'utilisateur a déjà vu cette musique, ne pas incrémenter
            return response()->json(['success' => true, 'already_viewed' => true]);
        }

        try {
            // Incrémenter le compteur de vues
            $music->increment('views');

            // Enregistrer la vue dans la table analytics avec try-catch pour éviter les doublons
            DB::table('analytics_music_views')->insert([
                'music_id' => $music->id,
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'viewed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true, 'view_counted' => true]);
        } catch (\Exception $e) {
            // En cas d'erreur (doublon), on ne fait rien
            return response()->json(['success' => true, 'already_viewed' => true]);
        }
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $music = Music::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $comment = $music->comments()->create([
            'user_id' => $user->id,
            'content' => $request->content
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }

    public function getComments(Request $request, $id)
    {
        $music = Music::findOrFail($id);
        $page = $request->get('page', 1);
        $perPage = 10;

        // Récupérer seulement les commentaires parents (pas les réponses)
        $comments = $music->comments()
            ->whereNull('parent_id') // Seulement les commentaires parents
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page)
            ->map(function ($comment) {
                // Pour l'instant, pas de système de likes pour les commentaires
                $comment->likes_count = 0;
                $comment->is_liked = false;



                return $comment;
            });

        return response()->json([
            'comments' => $comments,
            'hasMore' => $comments->hasMorePages()
        ]);
    }
}
