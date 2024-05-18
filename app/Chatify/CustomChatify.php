<?php

namespace App\Chatify;

use Chatify\Facades\ChatifyMessenger;
use App\Models\ChMessage as Message;
use App\Models\ChFavorite as Favorite;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;
use Illuminate\Support\Facades\Auth;
use Exception;


class CustomChatify extends ChatifyMessenger
{
    /**
     * create a new message to database
     *
     * @param array $data
     * @return Message
     */
    public static function newMessage($data)
    {
        if (isset($data['type'])) {
            $message = new Message();
            $message->type = $data['type'];
            $message->room_id = $data['room_id'];
            $message->from_id = $data['from_id'];
            $message->to_id = $data['to_id'];
            $message->body = $data['body'];
            $message->attachment = $data['attachment'];
            $message->save();
        } else {
            $message = new Message();
            $message->from_id = $data['from_id'];
            $message->to_id = $data['to_id'];
            $message->body = $data['body'];
            $message->attachment = $data['attachment'];
            $message->save();
        }
        return $message;
    }
}
