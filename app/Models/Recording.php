<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'song_id',
        'file_url',
    ];

    public function song(){
        return $this->belongsTo(Song::class,'song_id','id');
    }
    public function room(){
        return $this->belongsTo(Room::class,'room_id','room_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
