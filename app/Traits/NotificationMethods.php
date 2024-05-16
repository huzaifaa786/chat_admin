<?php

namespace App\Traits;

use App\Enums\Notification\NotificationType;
use Illuminate\Support\Facades\Hash;

trait NotificationMethods
{
    public function setNotificationTypeAttribute($value)
    {
        $status = match ($value) {
            'MESSAGE' => NotificationType::MESSAGE,
            'FOLLOW' => NotificationType::FOLLOW,
            'INVITE' => NotificationType::INVITE,
            default => NotificationType::MESSAGE,
        };
        return $this->attributes['notification_type'] = $status;
    }

    public function getNotificationTypeAttribute($value)
    {
        return NotificationType::from($value)->name;
    }



}
