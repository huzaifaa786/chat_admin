<?php
namespace App\Enums\Notification;

enum NotificationType:int {
    case MESSAGE = 0;
    case FOLLOW = 1;
    case INVITE = 2;
}
