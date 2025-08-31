<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(Request $request, $userId)
    {
        $userToFollow = User::findOrFail($userId);
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        if ($currentUser->id === $userToFollow->id) {
            return response()->json(['error' => 'Vous ne pouvez pas vous abonner à vous-même'], 400);
        }

        $isFollowing = $currentUser->following()->where('following_id', $userToFollow->id)->exists();

        if ($isFollowing) {
            // Se désabonner
            $currentUser->following()->detach($userToFollow->id);
            return response()->json([
                'success' => true,
                'action' => 'unfollowed',
                'message' => 'Désabonné de ' . $userToFollow->name
            ]);
        } else {
            // S'abonner
            $currentUser->following()->attach($userToFollow->id);
            return response()->json([
                'success' => true,
                'action' => 'followed',
                'message' => 'Abonné à ' . $userToFollow->name
            ]);
        }
    }

    public function getFollowers($userId)
    {
        $user = User::findOrFail($userId);
        $followers = $user->followers()->with('follower')->paginate(20);

        return response()->json([
            'followers' => $followers
        ]);
    }

    public function getFollowing($userId)
    {
        $user = User::findOrFail($userId);
        $following = $user->following()->paginate(20);

        return response()->json([
            'following' => $following
        ]);
    }

    public function unfollow(Request $request, $userId)
    {
        $userToUnfollow = User::findOrFail($userId);
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        if ($currentUser->id === $userToUnfollow->id) {
            return response()->json(['error' => 'Vous ne pouvez pas vous désabonner de vous-même'], 400);
        }

        $isFollowing = $currentUser->following()->where('following_id', $userToUnfollow->id)->exists();

        if (!$isFollowing) {
            return response()->json(['error' => 'Vous n\'êtes pas abonné à cet utilisateur'], 400);
        }

        // Se désabonner
        $currentUser->following()->detach($userToUnfollow->id);
        
        return response()->json([
            'success' => true,
            'message' => 'Désabonné de ' . $userToUnfollow->name
        ]);
    }
}
