<?php

namespace App\Models;

use App\Traits\NotificationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, NotificationMethods;
    protected $fillable = [
        'recipient_id',
        'sender_id',
        'notification_type',
        'title',
        'content',
        'read',
        'room_id',
    ];

    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver(){
        return $this->belongsTo(User::class,'recipient_id');
    }
}
