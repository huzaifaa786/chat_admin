<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function createUser(UserCreateRequest $request)
    {
        try {

            $user = User::create($request->all());


            $user->token = $user->createToken("mobile", ['role:user'])->plainTextToken;

            return Api::setResponse('user', $user);

        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }

    public function userDetail()
    {
        $user = Auth::user();
        if ($user) {
            $data = [
                "user" => $user,
                "followers" => $user->followers,
                "followees" => $user->followees,
            ];
            return Api::setResponse("data", $data);
        } else {
            return Api::setError("User not found");
        }
    }

    public function loginUser(UserLoginRequest $request)
    {
        try {

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials'],
                ]);
            }

            $user->token = $user->createToken("mobile", ['role:user'])->plainTextToken;

            return Api::setResponse('user', $user);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
