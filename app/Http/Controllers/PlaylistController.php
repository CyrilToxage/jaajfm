<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $playlists = $user->playlists()->withCount('musics')->with(['musics'])->get();

        // Debug: logger les données des playlists
        \Log::info('Playlists trouvées:', [
            'count' => $playlists->count(),
            'playlists' => $playlists->map(function ($playlist) {
                return [
                    'id' => $playlist->id,
                    'name' => $playlist->name,
                    'cover_image' => $playlist->cover_image,
                    'cover_image_url' => $playlist->cover_image_url ?? 'non défini'
                ];
            })->toArray()
        ]);

        // Générer les slugs manquants
        foreach ($playlists as $playlist) {
            if (empty($playlist->slug)) {
                $playlist->update(['slug' => $this->generateSlug($playlist->name)]);
                $playlist->refresh();
            }
        }

        // Récupérer les playlists recommandées basées sur les musiques et genres communs
        $recommendedPlaylists = $this->getRecommendedPlaylists($user);

        return Inertia::render('Playlists', [
            'playlists' => $playlists,
            'recommendedPlaylists' => $recommendedPlaylists
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Debug: logger les données reçues
            \Log::info('Données reçues pour création playlist:', [
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => $request->is_public,
                'is_public_type' => gettype($request->is_public),
                'all_data' => $request->all(),
                'has_cover_image' => $request->hasFile('cover_image'),
                'user_id' => Auth::id()
            ]);

            // Vérifier que l'utilisateur est authentifié
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'is_public' => 'nullable|in:true,false,1,0,on',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Convertir is_public en boolean de manière robuste
            $isPublic = true; // valeur par défaut
            if ($request->has('is_public')) {
                $isPublicValue = $request->is_public;
                if (is_string($isPublicValue)) {
                    $isPublic = in_array(strtolower($isPublicValue), ['true', '1', 'on', 'yes']);
                } else {
                    $isPublic = (bool) $isPublicValue;
                }
            }

            $playlistData = [
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => $isPublic
            ];

            // Ajouter le slug
            $playlistData['slug'] = $this->generateSlug($request->name);

            // Gérer l'upload de l'image de cover
            if ($request->hasFile('cover_image')) {
                try {
                    $file = $request->file('cover_image');

                    // Vérifications de base
                    if (!$file || !$file->isValid()) {
                        \Log::error('Fichier invalide:', [
                            'has_file' => $request->hasFile('cover_image'),
                            'is_valid' => $file ? $file->isValid() : false,
                            'error' => $file ? $file->getError() : 'No file'
                        ]);
                        throw new \Exception('Fichier invalide');
                    }

                    // Utiliser move() au lieu de store() pour éviter le problème de path
                    $uploadDir = storage_path('app/public/playlist-covers');
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $uploadDir . '/' . $fileName;

                    // Déplacer le fichier
                    $file->move($uploadDir, $fileName);

                    // Sauvegarder le chemin relatif
                    $playlistData['cover_image'] = '/storage/playlist-covers/' . $fileName;

                    \Log::info('Image de cover uploadée avec succès:', [
                        'file_path' => $filePath,
                        'web_path' => $playlistData['cover_image'],
                        'size' => $file->getSize(),
                        'name' => $file->getClientOriginalName()
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Erreur upload image:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    // Continuer sans image si l'upload échoue
                }
            }

            // Log des données avant création
            \Log::info('Données de playlist à créer:', $playlistData);

            $playlist = Auth::user()->playlists()->create($playlistData);

            return response()->json([
                'success' => true,
                'playlist' => $playlist->load('musics')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Erreur création playlist: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la playlist: ' . $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }

    public function show($identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Debug: logger les données de la playlist
        \Log::info('Playlist trouvée:', [
            'id' => $playlist->id,
            'name' => $playlist->name,
            'cover_image' => $playlist->cover_image,
            'cover_image_url' => $playlist->cover_image_url ?? 'non défini'
        ]);

        // Vérifier si l'utilisateur peut voir cette playlist
        if (!$playlist->is_public && $playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $playlist->load(['musics.user', 'musics.genres', 'user']);

        // Charger les musiques dans l'ordre correct
        $orderedMusics = $playlist->musics()->orderBy('playlist_music.order')->with(['user', 'genres'])->get();
        $playlist->setRelation('musics', $orderedMusics);

        return Inertia::render('Playlist/Show', [
            'playlist' => $playlist
        ]);
    }

    public function addMusic(Request $request, $identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $request->validate([
            'music_id' => 'required|exists:musics,id'
        ]);

        // Vérifier si la musique n'est pas déjà dans la playlist
        if ($playlist->musics()->where('music_id', $request->music_id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette musique est déjà dans la playlist'
            ]);
        }

        // Ajouter la musique à la playlist avec l'ordre
        $nextOrder = $playlist->musics()->count() + 1;
        $playlist->musics()->attach($request->music_id, [
            'order' => $nextOrder
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Musique ajoutée à la playlist'
        ]);
    }

    public function removeMusic(Request $request, $identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $request->validate([
            'music_id' => 'required|exists:musics,id'
        ]);

        $playlist->musics()->detach($request->music_id);

        return response()->json([
            'success' => true,
            'message' => 'Musique retirée de la playlist'
        ]);
    }

    public function reorderMusic(Request $request, $identifier)
    {
        \Log::info('Reorder request received', [
            'identifier' => $identifier,
            'from_index' => $request->from_index,
            'to_index' => $request->to_index,
            'user_id' => Auth::id()
        ]);

        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            \Log::warning('Unauthorized reorder attempt', [
                'playlist_user_id' => $playlist->user_id,
                'current_user_id' => Auth::id()
            ]);
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $request->validate([
            'from_index' => 'required|integer|min:0',
            'to_index' => 'required|integer|min:0'
        ]);

        $fromIndex = $request->from_index;
        $toIndex = $request->to_index;

        // Récupérer toutes les musiques de la playlist avec leur ordre
        $musics = $playlist->musics()->orderBy('playlist_music.order')->get();

        if ($fromIndex >= $musics->count() || $toIndex >= $musics->count()) {
            \Log::error('Invalid index', [
                'from_index' => $fromIndex,
                'to_index' => $toIndex,
                'total_musics' => $musics->count()
            ]);
            return response()->json(['error' => 'Index invalide'], 400);
        }

        // Créer un tableau avec les musiques dans le bon ordre
        $reorderedMusics = $musics->toArray();

        // Retirer la musique de sa position actuelle
        $musicToMove = array_splice($reorderedMusics, $fromIndex, 1)[0];

        // Insérer la musique à sa nouvelle position
        array_splice($reorderedMusics, $toIndex, 0, [$musicToMove]);

        // Détacher toutes les musiques
        $playlist->musics()->detach();

        // Réattacher dans le nouvel ordre
        $newOrder = [];
        foreach ($reorderedMusics as $index => $music) {
            $newOrder[$music['id']] = ['order' => $index + 1];
        }

        $playlist->musics()->attach($newOrder);

        \Log::info('Reorder completed successfully', [
            'from_index' => $fromIndex,
            'to_index' => $toIndex,
            'music_moved' => $musicToMove['title']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ordre de la playlist mis à jour'
        ]);
    }

    public function update(Request $request, $identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean'
        ]);

        $playlist->update([
            'name' => $request->name,
            'slug' => $this->generateSlug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public
        ]);

        return response()->json([
            'success' => true,
            'playlist' => $playlist->load('musics')
        ]);
    }

    public function destroy($identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est propriétaire de la playlist
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $playlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Playlist supprimée'
        ]);
    }

    public function toggleVisibility($identifier)
    {
        // Chercher la playlist par slug ou ID
        $playlist = Playlist::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        // Vérifier que l'utilisateur est le propriétaire
        if ($playlist->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé'], 403);
        }

        // Toggle le statut public/privé
        $playlist->is_public = !$playlist->is_public;
        $playlist->save();

        return response()->json([
            'success' => true,
            'is_public' => $playlist->is_public,
            'message' => $playlist->is_public ? 'Playlist rendue publique' : 'Playlist rendue privée'
        ]);
    }

    public function getUserPlaylists()
    {
        $playlists = Auth::user()->playlists()->select('id', 'name', 'slug', 'description', 'cover_image')->withCount('musics')->get();

        // Générer les slugs manquants
        foreach ($playlists as $playlist) {
            if (empty($playlist->slug)) {
                $playlist->update(['slug' => $this->generateSlug($playlist->name)]);
                $playlist->refresh();
            }
        }

        return response()->json([
            'playlists' => $playlists
        ]);
    }

    private function generateSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Vérifier si le slug existe déjà
        while (Playlist::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function getRecommendedPlaylists($user)
    {
        // Récupérer toutes les musiques des playlists de l'utilisateur
        $userMusicIds = collect();
        $userGenreIds = collect();

        foreach ($user->playlists as $playlist) {
            foreach ($playlist->musics as $music) {
                $userMusicIds->push($music->id);
                foreach ($music->genres as $genre) {
                    $userGenreIds->push($genre->id);
                }
            }
        }

        // Si l'utilisateur n'a pas de musiques, retourner des playlists populaires
        if ($userMusicIds->isEmpty()) {
            return Playlist::where('is_public', true)
                ->where('user_id', '!=', $user->id)
                ->withCount('musics')
                ->with(['user', 'musics.genres'])
                ->orderBy('musics_count', 'desc')
                ->limit(6)
                ->get();
        }

        // Trouver les playlists publiques qui ont des musiques ou genres en commun
        $recommendedPlaylists = Playlist::where('is_public', true)
            ->where('user_id', '!=', $user->id)
            ->whereHas('musics', function ($query) use ($userMusicIds, $userGenreIds) {
                $query->where(function ($subQuery) use ($userMusicIds, $userGenreIds) {
                    // Musiques en commun
                    $subQuery->whereIn('musics.id', $userMusicIds->unique())
                        // Ou genres en commun
                        ->orWhereHas('genres', function ($genreQuery) use ($userGenreIds) {
                            $genreQuery->whereIn('music_genres.id', $userGenreIds->unique());
                        });
                });
            })
            ->withCount('musics')
            ->with(['user', 'musics.genres'])
            ->get()
            ->map(function ($playlist) use ($userMusicIds, $userGenreIds) {
                // Calculer un score de similarité
                $commonMusics = $playlist->musics->whereIn('id', $userMusicIds->unique())->count();
                $commonGenres = $playlist->musics->flatMap(function ($music) {
                    return $music->genres->pluck('id');
                })->intersect($userGenreIds->unique())->count();
                
                $playlist->similarity_score = $commonMusics * 2 + $commonGenres; // Musiques communes ont plus de poids
                return $playlist;
            })
            ->sortByDesc('similarity_score')
            ->take(6);

        // Si pas assez de recommandations, ajouter des playlists populaires
        if ($recommendedPlaylists->count() < 6) {
            $popularPlaylists = Playlist::where('is_public', true)
                ->where('user_id', '!=', $user->id)
                ->whereNotIn('id', $recommendedPlaylists->pluck('id'))
                ->withCount('musics')
                ->with(['user', 'musics.genres'])
                ->orderBy('musics_count', 'desc')
                ->limit(6 - $recommendedPlaylists->count())
                ->get();

            $recommendedPlaylists = $recommendedPlaylists->merge($popularPlaylists);
        }

        return $recommendedPlaylists;
    }
}
