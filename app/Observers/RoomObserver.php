<?php

namespace App\Observers;

use App\Events\RoomCreated;
use App\Models\Room;
use Illuminate\Mail\Events\MessageSent;

class RoomObserver
{
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        RoomCreated::dispatch($room);
    }

    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "deleted" event.
     */
    public function deleted(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "restored" event.
     */
    public function restored(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "force deleted" event.
     */
    public function forceDeleted(Room $room): void
    {
        //
    }
}
