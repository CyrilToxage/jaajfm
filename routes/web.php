<?php

use App\Http\Controllers\MusicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




// Routes publiques (non connectés)
Route::get('/', [MusicController::class, 'index'])->name('welcome');
Route::get('/rankings', [PageController::class, 'rankings'])->name('rankings');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/help', [PageController::class, 'help'])->name('help');

// Routes d'authentification Fortify
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::post('/register', function () {
    $creator = app(\Laravel\Fortify\Contracts\CreatesNewUsers::class);
    $user = $creator->create(request()->all());

    // Connecter automatiquement l'utilisateur
    auth()->login($user);

    return redirect('/');
})->name('register.post');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->only(['email', 'password']);
    $remember = request()->boolean('remember');

    if (auth()->attempt($credentials, $remember)) {
        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
    ]);
})->name('login.post');



// Route pour la page détaillée d'une musique (accessible à tous)
Route::get('/music/{identifier}', [MusicController::class, 'show'])->name('music.show');

// Routes pour les genres musicaux (accessibles à tous)
Route::get('/genres', [App\Http\Controllers\MusicGenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{slug}', [App\Http\Controllers\MusicGenreController::class, 'show'])->name('genres.show');
Route::get('/api/genres', [App\Http\Controllers\MusicGenreController::class, 'getGenres'])->name('api.genres');
Route::get('/api/genres/{parentId}/sub-genres', [App\Http\Controllers\MusicGenreController::class, 'getSubGenres'])->name('api.sub-genres');
Route::get('/api/rankings', [App\Http\Controllers\RankingController::class, 'getRankings'])->name('api.rankings');

// Routes pour les interactions avec les musiques (accessibles à tous)
Route::post('/music/{id}/view', [MusicController::class, 'view'])->name('music.view');
Route::get('/music/{id}/comments', [MusicController::class, 'getComments'])->name('music.comments')->middleware('throttle:60,1');

// Routes Analytics
Route::post('/api/analytics', [App\Http\Controllers\AnalyticsController::class, 'store'])->name('api.analytics.store');
Route::get('/api/analytics/stats', [App\Http\Controllers\AnalyticsController::class, 'getStats'])->name('api.analytics.stats');
Route::get('/api/analytics/export', [App\Http\Controllers\AnalyticsController::class, 'exportUserData'])->name('api.analytics.export');
Route::delete('/api/analytics/delete', [App\Http\Controllers\AnalyticsController::class, 'deleteUserData'])->name('api.analytics.delete');

// Route pour incrémenter les vues d'une musique (accessible à tous)
Route::post('/music/{identifier}/view', [MusicController::class, 'incrementView'])->name('music.view');

// Route pour servir les fichiers audio
Route::get('/audio/{filename}', [App\Http\Controllers\AudioController::class, 'serve'])->name('audio.serve');

// Routes légales (accessibles à tous)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/legal', [PageController::class, 'legal'])->name('legal');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// Routes protégées (nécessitent une connexion)
Route::middleware([
    'auth:web',
    'verified',
])->group(function () {
    // Routes pour les interactions avec les musiques (nécessitent une connexion)
    Route::post('/music/{id}/like', [MusicController::class, 'like'])->name('music.like')->middleware('throttle:30,1');
    Route::post('/music/{id}/comments', [MusicController::class, 'addComment'])->name('music.comment.add')->middleware('throttle:10,1');

    // Routes pour les commentaires
    Route::post('/comments/{id}/like', [App\Http\Controllers\CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/{id}/replies', [App\Http\Controllers\CommentController::class, 'reply'])->name('comments.reply');
    Route::delete('/comments/{id}', [App\Http\Controllers\CommentController::class, 'delete'])->name('comments.delete');

    // Routes pour les signalements
    Route::post('/reports', [App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');

    // Routes pour les abonnements
    Route::post('/users/{userId}/follow', [FollowController::class, 'follow'])->name('users.follow');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/upload-music', [UserController::class, 'uploadMusic'])->name('upload.music');
    Route::get('/library', [UserController::class, 'library'])->name('library');
    Route::get('/subscriptions', [UserController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/likes', [UserController::class, 'likes'])->name('likes');

    Route::get('/dashboard', [MusicController::class, 'index'])->name('dashboard');

    // Routes de profil (spécifiques en premier)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/update', [ProfileController::class, 'updateProfileInformation'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Routes pour l'authentification à deux facteurs
    Route::post('/two-factor/enable', [App\Http\Controllers\TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::delete('/two-factor/disable', [App\Http\Controllers\TwoFactorController::class, 'disable'])->name('two-factor.disable');
    Route::post('/two-factor/regenerate-codes', [App\Http\Controllers\TwoFactorController::class, 'regenerateCodes'])->name('two-factor.regenerate-codes');

    // Routes d'abonnement
    Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userId}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/follow/check/{userId}', [FollowController::class, 'checkFollowStatus'])->name('follow.check');

    // Routes des playlists
    Route::get('/playlists', [App\Http\Controllers\PlaylistController::class, 'index'])->name('playlists.index');
    Route::post('/playlists', [App\Http\Controllers\PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{identifier}', [App\Http\Controllers\PlaylistController::class, 'show'])->name('playlists.show');
    Route::put('/playlists/{identifier}', [App\Http\Controllers\PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{identifier}', [App\Http\Controllers\PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::post('/playlists/{identifier}/add-music', [App\Http\Controllers\PlaylistController::class, 'addMusic'])->name('playlists.add-music');
    Route::patch('/playlists/{identifier}/toggle-visibility', [App\Http\Controllers\PlaylistController::class, 'toggleVisibility'])->name('playlists.toggle-visibility');
    Route::delete('/playlists/{identifier}/remove-music', [App\Http\Controllers\PlaylistController::class, 'removeMusic'])->name('playlists.remove-music');
    Route::post('/playlists/{identifier}/reorder', [App\Http\Controllers\PlaylistController::class, 'reorderMusic'])->name('playlists.reorder');

    // Routes pour les posts et commentaires
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/comments', [App\Http\Controllers\PostController::class, 'addComment'])->name('posts.comments.store');
    Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/comments/{comment}', [App\Http\Controllers\PostController::class, 'deleteComment'])->name('comments.destroy');
    Route::get('/playlists/user/list', [App\Http\Controllers\PlaylistController::class, 'getUserPlaylists'])->name('playlists.user-list');

    // Route pour supprimer une musique
    Route::delete('/music/{id}', [MusicController::class, 'deleteMusic'])->name('music.delete');

    // Routes de gestion du profil
    Route::put('/user/profile-information', [ProfileController::class, 'updateProfileInformation'])->name('user-profile-information.update');
    Route::post('/user/profile-photo', [ProfileController::class, 'updateProfilePhoto'])->name('user-profile-photo.store');
    Route::delete('/user/profile-photo', [ProfileController::class, 'destroyPhoto'])->name('current-user-photo.destroy');

    // Route de déconnexion (méthode standard Laravel)
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
});



// Routes Admin
Route::middleware(['auth:web', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/musics', [App\Http\Controllers\AdminController::class, 'musics'])->name('musics');
    Route::get('/rankings', [App\Http\Controllers\AdminController::class, 'rankings'])->name('rankings');
    Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('reports');
    // Actions admin
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::delete('/musics/{music}', [App\Http\Controllers\AdminController::class, 'deleteMusic'])->name('musics.delete');
    Route::patch('/reports/{report}/resolve', [App\Http\Controllers\ReportController::class, 'resolve'])->name('reports.resolve');

});

// Route pour voir les profils des utilisateurs (accessible à tous) - DOIT ÊTRE APRÈS LES ROUTES PROTÉGÉES
Route::get('/profile/{username}', [ProfileController::class, 'showUser'])->name('profile.user');



// Routes de debug supprimées pour la sécurité
