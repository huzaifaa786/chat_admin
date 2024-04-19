<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Models\User;
use App\Models\UserRelationship;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRelationshipController extends Controller
{

    // retrieve followers of a given user
    public function followers($userId)
    {
        $user = User::findOrFail($userId);
        $followers = $user->followers()->with('follower')->get();

        return Api::setResponse("followers", $followers);
    }

    // retrieve followees of a given user
    public function followees($userId)
    {
        $user = User::findOrFail($userId);
        $followees = $user->followees()->with('followee')->get();

        return Api::setResponse("followees", $followees);
    }
    // Follow a user
    public function follow(Request $request)
    {
        $followerId = Auth::id(); // Get the ID of the logged-in user

        // Check if the relationship already exists
        $existingRelationship = UserRelationship::where('follower_id', $followerId)
            ->where('followee_id', $request->followee_id)
            ->exists();

        if (!$existingRelationship) {
            // Create the relationship
            UserRelationship::create([
                'follower_id' => $followerId,
                'followee_id' => $request->followee_id,
            ]);
        }

        return Api::setMessage("Successfully followed user.", );
    }

    // Unfollow a user
    public function unfollow(Request $request)
    {
        $followerId = Auth::id(); // Get the ID of the logged-in user

        // Find and delete the relationship
        $relationship = UserRelationship::where('follower_id', $followerId)
            ->where('followee_id', $request->followee_id)
            ->first();

        if ($relationship) {
            $relationship->delete();
            return Api::setMessage("Successfully unfollowed user.");
        }

        return Api::setMessage("You are not following this user.");
    }

    // Check if the logged-in user is following a specific user
    public function isFollowing(Request $request)
    {
        $followerId = Auth::id(); // Get the ID of the logged-in user

        // Check if the relationship exists
        $isFollowing = UserRelationship::where('follower_id', $followerId)
            ->where('followee_id', $request->followee_id)
            ->exists();

        return Api::setResponse("is_following", $isFollowing);
    }
}
