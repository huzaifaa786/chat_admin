<?php
namespace App\Enums\Room;

enum RoomStatus: int
{
    case ACTIVE = 0;
    case ENDED = 1;
}
