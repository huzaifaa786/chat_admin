<?php

namespace App\Services;

// use App\Models\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public $serverKey;

    public function __construct()
    {
        $this->serverKey = env('FIREBASE_SERVER_KEY');
    }

    function sendNotification($senderId, $receiverId, $deviceToken, $roomId = null,  $title, $body, $type)
    {
        $notificationData = [
            'recipient_id' => $receiverId,
            'sender_id' => $senderId,
            'notification_type' => $type,
            'title' => $title,
            'content' => $body,
            'room_id' => $roomId,
        ];

        Notification::create($notificationData);

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', [
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'to' => $deviceToken,
                ]);

        return $response->json();
    }
}
