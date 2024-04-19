<?php

namespace App\Traits;

use App\Enums\Song\SongType;
use Illuminate\Support\Facades\Hash;

trait SongMethods
{
    public function setSongTypeAttribute($value){
        $status = match ($value) {
            'ENGLISH' => SongType::ENGLISH,
            'HINDI' => SongType::HINDI,
            'ARABIC' => SongType::ARABIC,
            default => SongType::ENGLISH,
        };
        return $this->attributes['song_type'] = $status;
    }

    public function getSongTypeAttribute($value)
    {
        return SongType::from($value)->name;
    }
}
