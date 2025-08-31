<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Music;
use App\Models\User;
use App\Models\MusicView;

class AnalyticsController extends Controller
{
    /**
     * Recevoir et traiter les événements analytics
     */
    public function store(Request $request)
    {
        $request->validate([
            'events' => 'required|array',
            'events.*.name' => 'required|string',
            'events.*.data' => 'array',
            'events.*.timestamp' => 'required|date',
            'events.*.url' => 'required|url'
        ]);

        $events = $request->input('events');
        $processedCount = 0;

        foreach ($events as $event) {
            try {
                $this->processEvent($event);
                $processedCount++;
            } catch (\Exception $e) {
                Log::error('Failed to process analytics event', [
                    'event' => $event,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'processed' => $processedCount,
            'total' => count($events)
        ]);
    }

    /**
     * Traiter un événement individuel
     */
    private function processEvent($event)
    {
        $eventName = $event['name'];
        $data = $event['data'] ?? [];
        $timestamp = $event['timestamp'];
        $url = $event['url'];

        switch ($eventName) {
            case 'music_play':
                $this->trackMusicPlay($data, $timestamp);
                break;

            case 'music_like':
                $this->trackMusicLike($data, $timestamp);
                break;

            case 'music_view':
                $this->trackMusicView($data, $timestamp);
                break;

            case 'user_follow':
                $this->trackUserFollow($data, $timestamp);
                break;

            case 'playlist_create':
                $this->trackPlaylistCreate($data, $timestamp);
                break;

            case 'search_performed':
                $this->trackSearch($data, $timestamp);
                break;

            case 'page_view':
                $this->trackPageView($data, $timestamp, $url);
                break;

            default:
                Log::info('Unknown analytics event', ['event' => $event]);
        }
    }

    /**
     * Tracker la lecture d'une musique
     */
    private function trackMusicPlay($data, $timestamp)
    {
        if (isset($data['music_id'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_music_plays')->insert([
                'music_id' => $data['music_id'],
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'played_at' => $mysqlTimestamp,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Tracker un like sur une musique
     */
    private function trackMusicLike($data, $timestamp)
    {
        if (isset($data['music_id'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_music_likes')->insert([
                'music_id' => $data['music_id'],
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'liked_at' => $mysqlTimestamp,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Tracker une vue de musique
     */
    private function trackMusicView($data, $timestamp)
    {
        if (isset($data['music_id'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_music_views')->insert([
                'music_id' => $data['music_id'],
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'viewed_at' => $mysqlTimestamp,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Tracker un follow d'utilisateur
     */
    private function trackUserFollow($data, $timestamp)
    {
        if (isset($data['followed_user_id'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_user_follows')->insert([
                'follower_id' => auth()->id(),
                'followed_id' => $data['followed_user_id'],
                'followed_at' => $mysqlTimestamp,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Tracker la création d'une playlist
     */
    private function trackPlaylistCreate($data, $timestamp)
    {
        if (isset($data['playlist_id'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_playlist_creates')->insert([
                'playlist_id' => $data['playlist_id'],
                'user_id' => auth()->id(),
                'created_at' => $mysqlTimestamp,
                'tracked_at' => now()
            ]);
        }
    }

    /**
     * Tracker une recherche
     */
    private function trackSearch($data, $timestamp)
    {
        if (isset($data['query'])) {
            // Convertir le timestamp ISO en format MySQL
            $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

            DB::table('analytics_searches')->insert([
                'query' => $data['query'],
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'results_count' => $data['results_count'] ?? 0,
                'searched_at' => $mysqlTimestamp,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Tracker une vue de page
     */
    private function trackPageView($data, $timestamp, $url)
    {
        // Convertir le timestamp ISO en format MySQL
        $mysqlTimestamp = \Carbon\Carbon::parse($timestamp)->format('Y-m-d H:i:s');

        DB::table('analytics_page_views')->insert([
            'url' => $url,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
            'viewed_at' => $mysqlTimestamp,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Obtenir les statistiques d'utilisation
     */
    public function getStats()
    {
        // Vérifier que l'utilisateur est admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $stats = [
            'total_plays' => DB::table('analytics_music_plays')->count(),
            'total_likes' => DB::table('analytics_music_likes')->count(),
            'total_views' => DB::table('analytics_music_views')->count(),
            'total_follows' => DB::table('analytics_user_follows')->count(),
            'total_searches' => DB::table('analytics_searches')->count(),
            'popular_searches' => DB::table('analytics_searches')
                ->select('query', DB::raw('count(*) as count'))
                ->groupBy('query')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'recent_activity' => DB::table('analytics_music_plays')
                ->join('musics', 'analytics_music_plays.music_id', '=', 'musics.id')
                ->select('musics.title', 'analytics_music_plays.played_at')
                ->orderBy('analytics_music_plays.played_at', 'desc')
                ->limit(20)
                ->get()
        ];

        return response()->json($stats)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Exporter les données utilisateur (RGPD)
     */
    public function exportUserData(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Filtrer les données sensibles
        $userData = [
            'user_info' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ],
            'music' => $user->musics()->with('genres')->get()->map(function ($music) {
                return [
                    'id' => $music->id,
                    'title' => $music->title,
                    'description' => $music->description,
                    'created_at' => $music->created_at,
                    'genres' => $music->genres->map(function ($genre) {
                        return ['name' => $genre->name];
                    })
                ];
            }),
            'playlists' => $user->playlists()->with('musics')->get()->map(function ($playlist) {
                return [
                    'id' => $playlist->id,
                    'name' => $playlist->name,
                    'description' => $playlist->description,
                    'is_public' => $playlist->is_public,
                    'created_at' => $playlist->created_at,
                    'musics_count' => $playlist->musics->count()
                ];
            }),
            'likes' => $user->likes()->with('music')->get()->map(function ($like) {
                return [
                    'music_id' => $like->music_id,
                    'music_title' => $like->music->title ?? 'Musique supprimée',
                    'liked_at' => $like->created_at
                ];
            }),
            'follows' => $user->follows()->with('followed')->get()->map(function ($follow) {
                return [
                    'followed_id' => $follow->followed_id,
                    'followed_name' => $follow->followed->name ?? 'Utilisateur supprimé',
                    'followed_at' => $follow->created_at
                ];
            }),
            'followers' => $user->followers()->with('follower')->get()->map(function ($follower) {
                return [
                    'follower_id' => $follower->follower_id,
                    'follower_name' => $follower->follower->name ?? 'Utilisateur supprimé',
                    'followed_at' => $follower->created_at
                ];
            }),
            'posts' => $user->posts()->with('comments.user')->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => $post->content,
                    'is_public' => $post->is_public,
                    'created_at' => $post->created_at,
                    'comments_count' => $post->comments->count()
                ];
            }),
            'comments' => $user->postComments()->with('post')->get()->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'post_id' => $comment->post_id,
                    'created_at' => $comment->created_at
                ];
            }),
            'analytics' => [
                'plays_count' => DB::table('analytics_music_plays')->where('user_id', $user->id)->count(),
                'views_count' => DB::table('analytics_music_views')->where('user_id', $user->id)->count(),
                'searches_count' => DB::table('analytics_searches')->where('user_id', $user->id)->count(),
                'page_views_count' => DB::table('analytics_page_views')->where('user_id', $user->id)->count()
            ]
        ];

        return response()->json($userData)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Supprimer les données utilisateur (RGPD)
     */
    public function deleteUserData(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Supprimer toutes les données analytics de l'utilisateur
        DB::table('analytics_music_plays')->where('user_id', $user->id)->delete();
        DB::table('analytics_music_views')->where('user_id', $user->id)->delete();
        DB::table('analytics_searches')->where('user_id', $user->id)->delete();
        DB::table('analytics_page_views')->where('user_id', $user->id)->delete();
        DB::table('analytics_user_follows')->where('follower_id', $user->id)->delete();
        DB::table('analytics_user_follows')->where('followed_id', $user->id)->delete();

        return response()->json(['success' => true, 'message' => 'User data deleted successfully']);
    }
}
