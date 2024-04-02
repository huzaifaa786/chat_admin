<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createRoom(Request $request)
    {
        try {
            $room = Room::create($request->all());
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

    public function getMultiRooms()
    {
        $rooms = Room::where('room_type', 'multi')->where('room_status', 'live')->with('song')->get();
        return Api::setResponse('rooms', $rooms);
    }
    public function getSoloRooms()
    {
        $rooms = Room::where('room_type', 'solo')->where('room_status', 'live')->with('song')->get();
        return Api::setResponse('rooms', $rooms);
    }
}
