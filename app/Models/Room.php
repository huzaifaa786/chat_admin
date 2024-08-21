<?php

namespace App\Models;

use App\Traits\RoomMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use HasFactory, RoomMethods;

    protected $fillable = [
        'room_id',
        'host_id',
        'host_name',
        'audience_count',
        'room_type',
        'room_status',
        'song_id',
        'room_name',
        'room_visibility',
        'bulletin_message',
    ];

    protected $appends = ['is_blocked'];


    public function getIsBlockedAttribute(): bool
    {
        if (Auth::check()) {
            return BlockedUser::where('blocked_user_id', Auth::id())
                ->where('blocked_room_id', $this->id)
                ->where('block_type', 'room')
                ->where('is_unblocked', false)
                ->exists();
        }
        return false;
    }
    public function song()
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }

    public function requests()
    {
        return $this->hasMany(SongQueueRequest::class, 'room_id', 'room_id');
    }
}
