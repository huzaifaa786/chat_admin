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
        (new NotificationService)->sendNotification($sender->id, $receiver->id, $receiver->fcm_token, null, "New message received", "you have received a new message from " . $receiver->name, "MESSAGE");
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
