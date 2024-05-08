<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'is_online'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['is_following'];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function getIsFollowingAttribute(): bool
    {
        // Check if the authenticated user is following this user
        if (Auth::check()) {
            return $this->followers()->where('follower_id', Auth::id())->exists();
        }

        return false;
    }
    /**
     * Method setImageAttribute
     *
     * @param $value $value [explicite description]
     *
     * @return void
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
            set: fn(string $value) => ImageHelper::saveImageFromApi($value, 'images/user')
        );
    }

    public function followers()
    {
        return $this->hasMany(UserRelationship::class, 'followee_id');
    }

    // define relationship with UserRelationship model for followees

    public function followees()
    {
        return $this->hasMany(UserRelationship::class, 'follower_id');
    }

}
