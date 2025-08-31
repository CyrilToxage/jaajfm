<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Récupérer les musiques de l'utilisateur
        $userTracks = $user->musics()->with(['genres', 'likes'])->withCount('likes')->get();

        // Récupérer les playlists publiques de l'utilisateur
        $publicPlaylists = $user->playlists()
            ->where('is_public', true)
            ->select('id', 'name', 'slug', 'description', 'cover_image', 'is_public')
            ->get();

        // Ajouter le nombre de musiques manuellement
        foreach ($publicPlaylists as $playlist) {
            $playlist->musics_count = $playlist->musics()->count();
            // Ajouter l'URL de l'image de cover
            $playlist->cover_image_url = $playlist->cover_image ? $playlist->cover_image : null;
        }

        // Récupérer les posts publics de l'utilisateur
        $publicPosts = $user->posts()->where('is_public', true)->with(['user', 'comments.user'])->orderBy('created_at', 'desc')->get();

        // Générer les slugs manquants pour les playlists
        $this->generateMissingSlugs($publicPlaylists);

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'userTracks' => $userTracks,
            'publicPlaylists' => $publicPlaylists,
            'publicPosts' => $publicPosts,
            'auth' => [
                'user' => $user
            ],
            'isFollowing' => false, // On ne peut pas se suivre soi-même
            'followersCount' => $user->followers()->count()
        ]);
    }

    public function settings()
    {
        return Inertia::render('Profile/Settings', [
            'user' => Auth::user(),
            'sessions' => [],
            'confirmsTwoFactorAuthentication' => false,
        ]);
    }

    private function generateMissingSlugs($playlists)
    {
        foreach ($playlists as $playlist) {
            if (empty($playlist->slug)) {
                // Mettre à jour seulement le slug, pas les autres attributs
                \DB::table('playlists')->where('id', $playlist->id)->update(['slug' => Str::slug($playlist->name)]);
                $playlist->slug = Str::slug($playlist->name);
            }
        }
    }

    public function showUser($username)
    {
        // Décoder l'URL et récupérer l'utilisateur par son nom
        $decodedUsername = urldecode($username);
        $user = \App\Models\User::where('name', $decodedUsername)->firstOrFail();

        // Récupérer les musiques de l'utilisateur
        $userTracks = $user->musics()->with(['genres', 'likes'])->withCount('likes')->get();

        // Récupérer les playlists publiques de l'utilisateur
        $publicPlaylists = $user->playlists()
            ->where('is_public', true)
            ->select('id', 'name', 'slug', 'description', 'cover_image', 'is_public')
            ->get();

        // Ajouter le nombre de musiques manuellement
        foreach ($publicPlaylists as $playlist) {
            $playlist->musics_count = $playlist->musics()->count();
            // Ajouter l'URL de l'image de cover
            $playlist->cover_image_url = $playlist->cover_image ? $playlist->cover_image : null;
        }

        // Récupérer les posts publics de l'utilisateur
        $publicPosts = $user->posts()->where('is_public', true)->with(['user', 'comments.user'])->orderBy('created_at', 'desc')->get();

        // Vérifier si l'utilisateur connecté suit cet utilisateur
        $currentUser = Auth::user();
        $isFollowing = $currentUser ? $currentUser->isFollowing($user) : false;

        // Générer les slugs manquants pour les playlists
        $this->generateMissingSlugs($publicPlaylists);

        return Inertia::render('Profile/Show', [
            'user' => $user,
            'userTracks' => $userTracks,
            'publicPlaylists' => $publicPlaylists,
            'publicPosts' => $publicPosts,
            'auth' => [
                'user' => $currentUser
            ],
            'isFollowing' => $isFollowing,
            'followersCount' => $user->followers()->count()
        ]);
    }

    public function updateProfileInformation(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'], // 1MB max
        ]);

        // Mettre à jour les informations de base
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Gérer l'upload de photo si fournie et valide
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Vérifications complètes du fichier
            if (
                !$file->isValid() ||
                $file->getSize() <= 0 ||
                !$file->getPathname() ||
                !file_exists($file->getPathname()) ||
                !is_uploaded_file($file->getPathname())
            ) {

                \Log::warning('Fichier photo invalide', [
                    'user_id' => $user->id,
                    'has_file' => $request->hasFile('photo'),
                    'is_valid' => $file ? $file->isValid() : false,
                    'file_size' => $file ? $file->getSize() : 'N/A',
                    'file_path' => $file ? $file->getPathname() : 'N/A',
                    'file_exists' => $file ? file_exists($file->getPathname()) : false,
                    'is_uploaded' => $file ? is_uploaded_file($file->getPathname()) : false
                ]);

                return redirect()->back()->withErrors(['photo' => 'Le fichier photo n\'est pas valide.']);
            }

            try {
                // Créer le dossier s'il n'existe pas
                $storagePath = storage_path('app/public/profile-photos');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }

                // Supprimer l'ancienne photo si elle existe
                if ($user->profile_photo_path) {
                    $oldPath = storage_path('app/public/' . $user->profile_photo_path);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Sauvegarder la nouvelle photo avec move() au lieu de store()
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = storage_path('app/public/profile-photos/' . $filename);

                \Log::info('Tentative d\'upload photo', [
                    'filename' => $filename,
                    'destination' => $destinationPath,
                    'file_size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName()
                ]);

                // Déplacer le fichier
                if ($file->move(storage_path('app/public/profile-photos'), $filename)) {
                    $path = 'profile-photos/' . $filename;

                    \Log::info('Fichier déplacé avec succès', [
                        'path' => $path,
                        'full_path' => $destinationPath
                    ]);

                    // Utiliser save() au lieu d'update()
                    $user->profile_photo_path = $path;
                    $result = $user->save();

                    \Log::info('Résultat du save', [
                        'user_id' => $user->id,
                        'new_photo_path' => $path,
                        'save_result' => $result,
                        'user_after_save' => $user->fresh()->toArray()
                    ]);

                    // Mettre à jour la session pour que la sidebar se mette à jour
                    $freshUser = $user->fresh();
                    // Forcer l'URL correcte
                    $freshUser->profile_photo_url = 'http://jaajfm.test/storage/' . $path;
                    $request->session()->put('auth.user', $freshUser);
                } else {
                    throw new \Exception('Impossible de déplacer le fichier uploadé');
                }
            } catch (\Exception $e) {
                \Log::error('Erreur upload photo profil: ' . $e->getMessage(), [
                    'user_id' => $user->id,
                    'file_size' => $file->getSize(),
                    'file_path' => $file->getPathname(),
                    'file_exists' => file_exists($file->getPathname()),
                    'is_uploaded' => is_uploaded_file($file->getPathname())
                ]);

                return redirect()->back()->withErrors(['photo' => 'Erreur lors de l\'upload de la photo.']);
            }
        }

        // Mettre à jour les données Inertia pour que la sidebar se mette à jour
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:1024'], // 1MB max
        ]);

        $user = Auth::user();

        $file = $request->file('photo');

        // Vérifications complètes du fichier
        if (
            !$request->hasFile('photo') ||
            !$file->isValid() ||
            $file->getSize() <= 0 ||
            !$file->getPathname() ||
            !file_exists($file->getPathname()) ||
            !is_uploaded_file($file->getPathname())
        ) {
            \Log::warning('Fichier photo invalide (API)', [
                'user_id' => $user->id,
                'has_file' => $request->hasFile('photo'),
                'is_valid' => $file ? $file->isValid() : false,
                'file_size' => $file ? $file->getSize() : 'N/A',
                'file_path' => $file ? $file->getPathname() : 'N/A',
                'file_exists' => $file ? file_exists($file->getPathname()) : false,
                'is_uploaded' => $file ? is_uploaded_file($file->getPathname()) : false
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Le fichier photo n\'est pas valide.'
            ], 400);
        }

        try {
            // Créer le dossier s'il n'existe pas
            $storagePath = storage_path('app/public/profile-photos');
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_photo_path) {
                $oldPath = storage_path('app/public/' . $user->profile_photo_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Sauvegarder la nouvelle photo avec move() au lieu de store()
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/profile-photos/' . $filename);

            // Déplacer le fichier
            if ($file->move(storage_path('app/public/profile-photos'), $filename)) {
                $path = 'profile-photos/' . $filename;

                // Utiliser save() au lieu d'update()
                $user->profile_photo_path = $path;
                $result = $user->save();

                \Log::info('Résultat du save (API)', [
                    'user_id' => $user->id,
                    'new_photo_path' => $path,
                    'save_result' => $result
                ]);

                // Mettre à jour la session pour que la sidebar se mette à jour
                $freshUser = $user->fresh();
                // Forcer l'URL correcte
                $freshUser->profile_photo_url = 'http://jaajfm.test/storage/' . $path;
                $request->session()->put('auth.user', $freshUser);
            } else {
                throw new \Exception('Impossible de déplacer le fichier uploadé');
            }

            return response()->json([
                'success' => true,
                'message' => 'Photo de profil mise à jour avec succès.',
                'photo_url' => $user->fresh()->profile_photo_url
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur upload photo profil (API): ' . $e->getMessage(), [
                'user_id' => $user->id,
                'file_size' => $file->getSize(),
                'file_path' => $file->getPathname(),
                'file_exists' => file_exists($file->getPathname()),
                'is_uploaded' => is_uploaded_file($file->getPathname())
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload de la photo.'
            ], 500);
        }
    }



    public function destroyPhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            // Supprimer le fichier
            $path = storage_path('app/public/' . $user->profile_photo_path);
            if (file_exists($path)) {
                unlink($path);
            }

            // Mettre à jour la base de données
            $user->update([
                'profile_photo_path' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Photo de profil supprimée avec succès.'
        ]);
    }
}
