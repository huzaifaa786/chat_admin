<?php

namespace App\Observers;

use App\Models\ChMessage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;
use Notification;

class ChMessageObserver
{
    /**
     * Handle the ChMessage "created" event.
     */
    public function created(ChMessage $chMessage): void
    {
        $sender = User::find($chMessage->from_id);
        $receiver = User::find($chMessage->to_id);
        $isInvite = false;
        if ($chMessage->type == "INVITE") {
            $isInvite = true;
        }
        (new NotificationService)->sendNotification($sender->id, $receiver->id, $receiver->fcm_token, null, $isInvite ? "New invitation received" : "New message received", $isInvite ? "you have received a new invitation from " . $sender->name : "you have received a new message from " . $sender->name, "MESSAGE");
    }

    /**
     * Handle the ChMessage "updated" event.
     */
    public function updated(ChMessage $chMessage): void
    {
        //
    }

    /**
     * Handle the ChMessage "deleted" event.
     */
    public function deleted(ChMessage $chMessage): void
    {
        //
    }

    /**
     * Handle the ChMessage "restored" event.
     */
    public function restored(ChMessage $chMessage): void
    {
        //
    }

    /**
     * Handle the ChMessage "force deleted" event.
     */
    public function forceDeleted(ChMessage $chMessage): void
    {
        //
    }
}
