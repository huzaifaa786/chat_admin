<?php

namespace App\Services;


use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public $serverKey;

    public function __construct()
    {
        $this->serverKey = "AAAAcoO4N50:APA91bG6LH0fFNNmUGhW1BkjKJuoOrERBbwFwdQH5WdqedMH2lCqAmlztJ7zgOYB82zZMg3oJUGIKLhj7st2Do1BqUuRoew7kthCNUww1YY2INAbAysJKE14sr1WazxGv4UfGbRMV3ni";
    }

    function sendNotification($senderId, $receiverId, $deviceToken, $roomId = null, $title, $body, $type)
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
