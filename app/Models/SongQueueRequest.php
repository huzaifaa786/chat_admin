<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongQueueRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'song_id',
        'singer_id',
    ];
}
