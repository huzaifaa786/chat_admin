<?php



namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\UserRelationship;
use Illuminate\Http\Request;
use App\Models\BlockedUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BlockedUserController extends Controller
{
    /**
     * Block a user.
     */
    public function blockUser(Request $request)
    {
        $request->validate([
            'blocked_user_id' => 'required|exists:users,id',
            'blocked_room_id' => 'nullable|exists:rooms,room_id',
            'block_duration' => 'nullable|integer|in:1,3,6,12', // Months
        ]);

        $blocker_id = Auth::id();
        $blocked_user_id = $request->blocked_user_id;
        $blocked_room_id = $request->blocked_room_id;
        $block_start_date = Carbon::now();
        $block_end_date = $request->block_duration ? $block_start_date->copy()->addMonths($request->block_duration) : null;
        $block_type = $blocked_room_id ? 'room' : 'app';

        // Check if the user is already blocked
        $existingBlock = BlockedUser::where('blocker_id', $blocker_id)
            ->where('blocked_user_id', $blocked_user_id)
            ->where('blocked_room_id', $blocked_room_id)
            ->where('is_unblocked', false)
            ->first();


        if ($existingBlock) {
            $user = User::find($blocked_user_id);
            return Api::setResponse('user', $user);
        }

        // Create the block
        $blockedUser = BlockedUser::create([
            'blocker_id' => $blocker_id,
            'blocked_user_id' => $blocked_user_id,
            'blocked_room_id' => $blocked_room_id,
            'block_start_date' => $block_start_date,
            'block_end_date' => $block_end_date,
            'block_type' => $block_type,
        ]);

        // Remove the blocked user from the follow and following lists
        UserRelationship::where('follower_id', $blocker_id)
            ->where('followee_id', $blocked_user_id)
            ->delete(); // Remove from following list

        UserRelationship::where('follower_id', $blocked_user_id)
            ->where('followee_id', $blocker_id)
            ->delete(); // Remove from followers list
        $user = User::find($blocked_user_id);
        return Api::setResponse('user', $user);

    }

    /**
     * Unblock a user.
     */
    public function unblockUser(Request $request)
    {
        $request->validate([
            'blocked_user_id' => 'required|exists:users,id',
            'blocked_room_id' => 'nullable|exists:rooms,room_id',
        ]);

        $blocker_id = Auth::id();
        $blocked_user_id = $request->blocked_user_id;
        $blocked_room_id = $request->blocked_room_id;

        $blockedUser = BlockedUser::where('blocker_id', $blocker_id)
            ->where('blocked_user_id', $blocked_user_id)
            ->where('blocked_room_id', $blocked_room_id)
            ->where('is_unblocked', false)
            ->first();

        if (!$blockedUser) {
            $user = User::find($blocked_user_id);
            return Api::setResponse('user', $user);

        }

        $blockedUser->update([
            'is_unblocked' => true,
        ]);

        $user = User::find($blocked_user_id);
        return Api::setResponse('user', $user);

    }

    /**
     * Get a list of blocked users.
     */
    public function blockedUsers(Request $request)
    {
        $blocker_id = Auth::id();
        $blockedUsers = BlockedUser::where('blocker_id', $blocker_id)
            ->where('is_unblocked', false)->where('block_type', 'app')->get();

        return Api::setResponse('blocked', $blockedUsers);
    }
    public function blockedRoomUsers(Request $request)
    {
        $blocker_id = Auth::id();
        $blockedUsers = BlockedUser::where('blocker_id', $blocker_id)
            ->where('is_unblocked', false)->where('block_type', 'room')->get();

        return Api::setResponse('blocked', $blockedUsers);
    }

    /**
     * Check if a user is blocked app-wide.
     */
    public function checkBlockAppWide(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
        ]);

        $authUserId = Auth::id();
        $targetUserId = $request->target_user_id;

        // Check if the target user is blocked by the authenticated user app-wide
        $appBlock = BlockedUser::where('blocker_id', $authUserId)
            ->where('blocked_user_id', $targetUserId)
            ->where('block_type', 'app')
            ->where('is_unblocked', false)
            ->exists();

        return Api::setResponse("appblock", $appBlock);
    }

    /**
     * Check if a user is blocked in a specific room.
     */
    public function checkBlockInRoom(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $authUserId = Auth::id();
        $targetUserId = $request->target_user_id;
        $roomId = $request->room_id;

        // Check if the target user is blocked by the authenticated user in the specified room
        $roomBlock = BlockedUser::where('blocker_id', $authUserId)
            ->where('blocked_user_id', $targetUserId)
            ->where('blocked_room_id', $roomId)
            ->where('block_type', 'room')
            ->where('is_unblocked', false)
            ->exists();

        return Api::setResponse("appblock", $roomBlock);

    }
}
