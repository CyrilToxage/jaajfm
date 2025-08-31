<?php

namespace App\Http\Controllers;

use App\Models\MusicComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function like(Request $request, $id)
    {
        $comment = MusicComment::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $existingLike = $comment->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            return response()->json([
                'success' => true,
                'action' => 'unliked',
                'message' => 'Like retiré'
            ]);
        } else {
            // Like
            $comment->likes()->create([
                'user_id' => $user->id
            ]);
            return response()->json([
                'success' => true,
                'action' => 'liked',
                'message' => 'Commentaire liké'
            ]);
        }
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $parentComment = MusicComment::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $reply = $parentComment->replies()->create([
            'user_id' => $user->id,
            'content' => $request->content,
            'music_id' => $parentComment->music_id
        ]);

        $reply->load('user');

        return response()->json([
            'success' => true,
            'reply' => $reply
        ]);
    }

    public function delete(Request $request, $id)
    {
        $comment = MusicComment::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Vérifier que l'utilisateur est le propriétaire du commentaire ou un admin
        if ($comment->user_id !== $user->id && !$user->is_admin) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé'
        ]);
    }
}
