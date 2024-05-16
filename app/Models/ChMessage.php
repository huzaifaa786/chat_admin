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
}
