<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'user_id',
    ];

    protected $with = ['user'];
    protected $appends = ['is_new'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
            set: fn(string $value) => ImageHelper::saveImageFromApi($value, 'images/products')
        );
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at->gt(Carbon::now()->subMinutes(5));
    }
}
