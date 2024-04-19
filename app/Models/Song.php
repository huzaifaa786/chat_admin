<?php

namespace App\Models;

use App\Traits\SongMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory, SongMethods;

    protected $fillable = [
        'name',
        'song_type',
        'singer_name',
        'thumbnail_image_url',
        'music_file_url',
        'lyrics_file_url',
    ];

}
