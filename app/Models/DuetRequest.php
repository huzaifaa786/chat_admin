<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'room_id',
    ];
}
