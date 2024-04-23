<?php
namespace App\Enums\Room;

enum RoomType:int {
    case CHAT = 0;
    case STAGE = 1;
    case SOLO = 2;
}
