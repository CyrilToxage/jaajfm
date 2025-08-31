<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Music;
use App\Models\Report;
use App\Models\Like;
use App\Models\MusicComment;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_musics' => Music::count(),
            'total_likes' => Like::count(),
            'total_comments' => MusicComment::count(),
            'total_playlists' => Playlist::count(),
            'pending_reports' => Schema::hasTable('reports') ? Report::pending()->count() : 0,
            'recent_users' => User::latest()->take(5)->get(),
            'recent_musics' => Music::with('user')->latest()->take(5)->get(),
            'recent_reports' => Schema::hasTable('reports') ? Report::with(['reporter', 'reportable'])->latest()->take(5)->get() : collect(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }

    public function users()
    {
        $users = User::withCount(['musics', 'likes', 'musicComments', 'playlists', 'followers', 'following'])
            ->with([
                'musics' => function ($query) {
                    $query->latest()->take(3);
                }
            ])
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    public function musics()
    {
        $musics = Music::with(['user', 'genres', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(20);

        // Ajouter le nombre de vues depuis le champ 'views' de la table musics
        $musics->getCollection()->transform(function ($music) {
            $music->views_count = $music->views ?? 0;
            return $music;
        });

        return Inertia::render('Admin/Musics', [
            'musics' => $musics
        ]);
    }

    public function rankings()
    {
        $rankings = [
            'most_liked' => Music::with('user')
                ->withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->take(10)
                ->get(),
            'most_viewed' => Music::with('user')
                ->orderBy('views', 'desc')
                ->take(10)
                ->get()
                ->map(function ($music) {
                    $music->views_count = $music->views ?? 0;
                    return $music;
                }),
            'most_commented' => Music::with('user')
                ->withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->take(10)
                ->get(),
            'top_users' => User::withCount(['musics', 'likes', 'followers'])
                ->orderBy('musics_count', 'desc')
                ->take(10)
                ->get(),
        ];

        return Inertia::render('Admin/Rankings', [
            'rankings' => $rankings
        ]);
    }

    public function reports()
    {
        if (!Schema::hasTable('reports')) {
            return Inertia::render('Admin/Reports', [
                'reports' => ['data' => [], 'links' => []],
                'stats' => ['pending' => 0, 'resolved' => 0, 'dismissed' => 0]
            ]);
        }

        $reports = Report::with(['reporter', 'reportable', 'resolvedBy'])
            ->latest()
            ->paginate(20);

        $stats = [
            'pending' => Report::pending()->count(),
            'resolved' => Report::resolved()->count(),
            'dismissed' => Report::dismissed()->count(),
        ];

        return Inertia::render('Admin/Reports', [
            'reports' => $reports,
            'stats' => $stats
        ]);
    }

    public function deleteUser(User $user)
    {
        // Supprimer toutes les données associées
        $user->musics()->delete();
        $user->likes()->delete();
        $user->musicComments()->delete();
        $user->playlists()->delete();

        // Supprimer les posts si la table existe
        if (Schema::hasTable('posts')) {
            $user->posts()->delete();
        }

        $user->reports()->delete();

        // Supprimer les relations de suivi
        DB::table('user_follows')->where('follower_id', $user->id)->delete();
        DB::table('user_follows')->where('following_id', $user->id)->delete();

        // Supprimer l'utilisateur
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function deleteMusic(Music $music)
    {
        // Supprimer les likes, commentaires, vues associés
        $music->likes()->delete();
        $music->comments()->delete();

        // Supprimer les vues si la table existe
        if (Schema::hasTable('music_views')) {
            $music->views()->delete();
        }

        // Supprimer les relations avec les playlists
        DB::table('playlist_music')->where('music_id', $music->id)->delete();

        // Supprimer les relations avec les genres
        $music->genres()->detach();

        // Supprimer le fichier audio
        if ($music->file_path && file_exists(public_path($music->file_path))) {
            unlink(public_path($music->file_path));
        }

        // Supprimer la musique
        $music->delete();

        return back()->with('success', 'Musique supprimée avec succès.');
    }

    public function resolveReport(Report $report)
    {
        if (!Schema::hasTable('reports')) {
            return back()->with('error', 'Table des signalements non disponible.');
        }

        $report->update([
            'status' => 'resolved',
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Signalement résolu avec succès.');
    }
}
