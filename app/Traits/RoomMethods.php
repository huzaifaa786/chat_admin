<?php

namespace App\Traits;

use App\Enums\Room\RoomStatus;
use App\Enums\Room\RoomType;
use App\Enums\Room\RoomVisibility;
use Illuminate\Support\Facades\Hash;

trait RoomMethods
{
    public function setRoomVisibilityAttribute($value)
    {
        $status = match ($value) {
            'PUBLIC' => RoomVisibility::PUBLIC ,
            'PRIVATE' => RoomVisibility::PRIVATE ,
            default => RoomVisibility::PUBLIC ,
        };
        return $this->attributes['room_visibility'] = $status;
    }

    public function getRoomVisibilityAttribute($value)
    {
        return $value->name;
    }

    public function setRoomTypeAttribute($value)
    {
        $status = match ($value) {
            'CHAT' => RoomType::CHAT,
            'STAGE' => RoomType::STAGE,
            'SOLO' => RoomType::SOLO,
            default => RoomType::CHAT,
        };
        return $this->attributes['room_type'] = $status;
    }

    public function getRoomTypeAttribute($value)
    {
        return $value->name;
    }

    public function setRoomStatusAttribute($value)
    {
        $status = match ($value) {
            'ACTIVE' => RoomStatus::ACTIVE,
            'ENDED' => RoomStatus::ENDED,
            default => RoomStatus::ACTIVE,
        };
        return $this->attributes['room_status'] = $status;
    }

    public function getRoomStatusAttribute($value)
    {
        return $value->name;
    }

}
