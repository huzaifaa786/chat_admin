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
        if ($data['type'] == "INVITE") {
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

    /**
     * Fetch & parse message and return the message card
     * view as a response.
     *
     * @param Message $prefetchedMessage
     * @param int $id
     * @return array
     */
    public static function parseMessage($prefetchedMessage = null, $id = null)
    {
        $msg = null;
        $attachment = null;
        $attachment_type = null;
        $attachment_title = null;
        if (!!$prefetchedMessage) {
            $msg = $prefetchedMessage;
        } else {
            $msg = Message::where('id', $id)->first();
            if (!$msg) {
                return [];
            }
        }
        if (isset($msg->attachment)) {
            $attachmentOBJ = json_decode($msg->attachment);
            $attachment = $attachmentOBJ->new_name;
            $attachment_title = htmlentities(trim($attachmentOBJ->old_name), ENT_QUOTES, 'UTF-8');
            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            // $attachment_type = in_array($ext, $this->getAllowedImages()) ? 'image' : 'file';
            $attachment_type = 'image';
        }
        return [
            'id' => $msg->id,
            'from_id' => $msg->from_id,
            'to_id' => $msg->to_id,
            'message' => $msg->body,
            'type' => $msg->type,
            'room_id' => $msg->room_id,
            'room'=>$msg->room,
            'attachment' => (object) [
                'file' => $attachment,
                'title' => $attachment_title,
                'type' => $attachment_type
            ],
            'timeAgo' => $msg->created_at->diffForHumans(),
            'created_at' => $msg->created_at->toIso8601String(),
            'isSender' => ($msg->from_id == Auth::user()->id),
            'seen' => $msg->seen,
        ];
    }
}
