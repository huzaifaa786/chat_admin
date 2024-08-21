<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class BlockedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocker_id',
        'blocked_user_id',
        'blocked_room_id',
        'block_start_date',
        'block_end_date',
        'block_type',
        'is_unblocked',
    ];

    /**
     * Get the user who blocked another user.
     */
    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocker_id');
    }

    /**
     * Get the user who was blocked.
     */
    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }

    /**
     * Get the room where the user is blocked.
     */
    public function blockedRoom()
    {
        return $this->belongsTo(Room::class, 'blocked_room_id');
    }
}
