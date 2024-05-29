<?php

namespace App\Http\Controllers\Api;

use App\Enums\Room\RoomStatus;
use App\Enums\Room\RoomType;
use App\Enums\Room\RoomVisibility;
use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function createRoom(Request $request)
    {
        try {
            $dbroom = Room::create($request->all());
            $room = Room::find($dbroom->id);
            return Api::setResponse('room', $room);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    public function updateRoomCount(Request $request)
    {
        $room = Room::where('room_id', $request->room_id)->first();
        if ($room != null) {
            $room->update([
                'audience_count' => $request->audience_count
            ]);
            return Api::setMessage('Room updated successfully');
        } else {
            return Api::setError('Room not found');
        }
    }
    public function updateRoomStatus(Request $request)
    {
        $room = Room::where('room_id', $request->room_id)->first();
        if ($room != null) {
            $room->update([
                'room_status' => $request->room_status
            ]);
            return Api::setMessage('Room updated successfully');
        } else {
            return Api::setError('Room not found');
        }
    }

    public function updateRoomType(Request $request)
    {
        $room = Room::where('room_id', $request->room_id)->first();
        if ($room != null) {
            $room->update([
                'room_type' => $request->room_type
            ]);
            return Api::setMessage('Room updated successfully');
        } else {
            return Api::setError('Room not found');
        }
    }

    public function getChatRooms()
    {
        $rooms = Room::where('room_type', RoomType::CHAT->value)
            ->where('room_visibility', RoomVisibility::PUBLIC ->value)
            ->where('room_status', RoomStatus::ACTIVE->value)
            ->get();

        // Fetch private chat rooms for the authenticated user
        $privateRooms = Room::where('room_visibility', RoomVisibility::PRIVATE ->value)->where('room_type', RoomType::CHAT->value)->where('host_id', Auth::id())->where('room_status', RoomStatus::ACTIVE->value)->get();

        // Merge the two collections
        $mergedRooms = $rooms->merge($privateRooms);


    }
    public function getQueueRooms()
    {
        $rooms = Room::where('room_type', RoomType::STAGE->value)->where('room_visibility', RoomVisibility::PUBLIC ->value)->where('room_status', RoomStatus::ACTIVE->value)->with('requests')->get();
        $privateRooms = Room::where('room_visibility', RoomVisibility::PRIVATE ->value)->where('room_type', RoomType::STAGE->value)->where('host_id', Auth::id())->where('room_status', RoomStatus::ACTIVE->value)->get();

        // Merge the two collections
        $mergedRooms = $rooms->merge($privateRooms);
        return Api::setResponse('rooms', $mergedRooms);
    }

    public function getRoomDetail($id)
    {
        $room = Room::where('room_id', $id)->with('requests')->first();
        return Api::setResponse('room', $room);
    }

    public function myRooms()
    {
        $rooms = Room::where('host_id', Auth::id())->where('room_status', RoomStatus::ACTIVE->value)->get();
        return Api::setResponse('rooms', $rooms);
    }

}
