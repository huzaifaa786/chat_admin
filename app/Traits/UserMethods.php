<?php

namespace App\Traits;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Hash;

trait UserMethods
{

    public static function registerRules()
    {
        return [
            'name' => 'max:255|required',
            'email' => 'email|required|unique:users',
            'password' => 'min:6|required',
        ];
    }


    public static function loginRules()
    {
        return [
            'email' => 'email|required',
            'password' => 'required'
        ];
    }

 
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function withToken()
    {
        return $this->makeVisible(['api_token']);
    }
}
