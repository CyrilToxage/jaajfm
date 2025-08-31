<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function library()
    {
        $user = Auth::user();

        $userTracks = Music::with(['user', 'genres'])
            ->withCount('likes')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $likedTracks = Music::with(['user', 'genres'])
            ->withCount('likes')
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $publicPlaylists = $user->playlists()
            ->where('is_public', true)
            ->select('id', 'name', 'slug', 'description', 'cover_image', 'is_public')
            ->withCount('musics')
            ->get();

        return Inertia::render('Library', [
            'userTracks' => $userTracks,
            'likedTracks' => $likedTracks,
            'publicPlaylists' => $publicPlaylists,
        ]);
    }

    public function likes()
    {
        $user = Auth::user();

        $likedTracks = Music::with(['user', 'genres'])
            ->withCount('likes')
            ->whereHas('likes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Likes', [
            'likedTracks' => $likedTracks,
        ]);
    }

    public function subscriptions()
    {
        $user = Auth::user();

        $subscriptions = User::with([
            'musics' => function ($query) {
                $query->with(['user', 'genres'])
                    ->withCount('likes')
                    ->where('is_public', true)
                    ->orderBy('created_at', 'desc');
            }
        ])
            ->whereHas('followers', function ($query) use ($user) {
                $query->where('follower_id', $user->id);
            })
            ->get();

        // Récupérer toutes les musiques des artistes suivis, triées par date de création (plus récentes en premier)
        $newReleases = collect();
        foreach ($subscriptions as $subscription) {
            foreach ($subscription->musics as $music) {
                $newReleases->push($music);
            }
        }

        // Trier par date de création décroissante
        $newReleases = $newReleases->sortByDesc('created_at')->values();

        return Inertia::render('Subscriptions', [
            'subscriptions' => $subscriptions,
            'newReleases' => $newReleases,
        ]);
    }

    public function create()
    {
        return Inertia::render('Create');
    }

    public function uploadMusic(Request $request)
    {
        // Validation des données
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'genre_ids' => 'required|array|min:1',
            'genre_ids.*' => 'exists:music_genres,id',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg,flac|max:51200', // 50MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'is_ai_generated' => 'boolean'
        ]);

        $user = Auth::user();

        try {
            // Log pour debug
            \App\Helpers\LogHelper::info('Upload musique - Données reçues:', [
                'has_audio_file' => $request->hasFile('audio_file'),
                'has_cover_image' => $request->hasFile('cover_image'),
                'title' => $request->title,
                'genre_ids' => $request->genre_ids
            ]);

            // Upload du fichier audio
            if (!$request->hasFile('audio_file')) {
                \Log::error('Aucun fichier audio fourni');
                return back()->withErrors(['audio_file' => 'Aucun fichier audio fourni']);
            }

            $audioFile = $request->file('audio_file');
            \Log::info('Fichier audio reçu:', [
                'name' => $audioFile->getClientOriginalName(),
                'size' => $audioFile->getSize(),
                'mime_type' => $audioFile->getMimeType(),
                'real_path' => $audioFile->getRealPath(),
                'is_valid' => $audioFile->isValid()
            ]);

            // Utiliser move() au lieu de store() pour éviter le problème de getRealPath()
            $filename = time() . '_' . uniqid() . '.' . $audioFile->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/uploads/music/' . $filename);

            // Créer le dossier s'il n'existe pas
            if (!file_exists(dirname($destinationPath))) {
                mkdir(dirname($destinationPath), 0755, true);
            }

            $audioFile->move(dirname($destinationPath), $filename);
            $audioPath = 'uploads/music/' . $filename;

            // Upload de l'image de couverture si fournie
            $coverPath = null;
            if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
                $coverFile = $request->file('cover_image');
                $coverFilename = time() . '_' . uniqid() . '.' . $coverFile->getClientOriginalExtension();
                $coverDestinationPath = storage_path('app/public/uploads/covers/' . $coverFilename);

                // Créer le dossier s'il n'existe pas
                if (!file_exists(dirname($coverDestinationPath))) {
                    mkdir(dirname($coverDestinationPath), 0755, true);
                }

                $coverFile->move(dirname($coverDestinationPath), $coverFilename);
                $coverPath = 'uploads/covers/' . $coverFilename;
            }

            // Créer la musique
            $musicData = [
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $audioPath,
                'cover_image' => $coverPath,
                'is_public' => true,
            ];

            // Ajouter is_ai_generated seulement si la colonne existe
            if (Schema::hasColumn('musics', 'is_ai_generated')) {
                $musicData['is_ai_generated'] = $request->input('is_ai_generated', false);
            }

            $music = Music::create($musicData);

            // Attacher les genres
            $music->genres()->attach($request->genre_ids);

            return response()->json([
                'success' => true,
                'message' => 'Musique uploadée avec succès !',
                'music_id' => $music->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur upload musique: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de l\'upload: ' . $e->getMessage()
            ], 500);
        }
    }
}
