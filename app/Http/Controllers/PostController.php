<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image_path' => 'nullable|string'
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'image_path' => $request->image_path,
            'is_public' => true
        ]);

        return response()->json([
            'success' => true,
            'post' => $post->load('user')
        ]);
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment = PostComment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user')
        ]);
    }

    public function destroy(Post $post)
    {
        // Vérifier que l'utilisateur connecté est le propriétaire du post
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce post'
            ], 403);
        }

        // Supprimer le post (les commentaires seront supprimés automatiquement grâce à la contrainte CASCADE)
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post supprimé avec succès'
        ]);
    }

    public function deleteComment(PostComment $comment)
    {
        // Charger la relation post pour vérifier le propriétaire
        $comment->load('post');

        // Vérifier que l'utilisateur connecté est le propriétaire du commentaire OU le propriétaire du post
        if ($comment->user_id !== Auth::id() && $comment->post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire'
            ], 403);
        }

        // Supprimer le commentaire
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé avec succès'
        ]);
    }
}
