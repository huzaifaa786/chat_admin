<?php

namespace App\Http\Controllers\Api;

use App\Enums\Notification\NotificationType;
use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotification()
    {
        $user = Auth::user();
        $notifications = Notification::where('recipient_id', $user->id)->where('notification_type', '!=', NotificationType::MESSAGE->value)->with('sender')->with('receiver')->get();
        return Api::setResponse('notifications', $notifications);
    }
}
