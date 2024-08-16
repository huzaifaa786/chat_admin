<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\RoomManager;
use Illuminate\Http\Request;

class RoomManagerController extends Controller
{
    public function addManager(Request $request)
    {
        $roomManager = RoomManager::create([
            'room_id' => $request->roomId,
            'manager_id' => $request->managerId,
        ]);
        return Api::setResponse("roomManager", $roomManager);
    }
    public function removeManager(Request $request)
    {
        $roomManager = RoomManager::where('room_id', $request->roomId)->where('manager_id', $request->managerId)->first();
        if ($roomManager) {
            $roomManager->delete();
        }
        return Api::setMessage("Manager removed successfully", );
    }

    public function getManagers(Request $request)
    {
        $roomManagers = RoomManager::where('room_id', $request->roomId)->get();
        return Api::setResponse('roomManagers', $roomManagers);

    }
}
