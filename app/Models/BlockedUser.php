<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
