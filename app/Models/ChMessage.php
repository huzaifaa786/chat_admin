<?php

namespace App\Models;

use App\Observers\ChMessageObserver;
use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ChMessageObserver::class])]
class ChMessage extends Model
{
    use UUID;

    protected $with = ['room'];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}


