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
            $user->followees;
            $user->followers;
            return Api::setResponse("user", $user);
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

    public function isOnline(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->is_online == "true") {
            $user->update([
                'is_online' => true,
            ]);
        } else if ($request->is_online == "false") {
            $user->update([
                'is_online' => false,
            ]);
        }
        return Api::setResponse('user', $user);
    }

    public function searchUser(Request $request)
    {
        $users = User::where('name', 'LIKE', "%{$request->keyword}%")->get();
        return Api::setResponse('users',$users);
    }
}
