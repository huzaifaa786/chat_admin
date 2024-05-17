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

            if ($request->has('fcm_token')) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
            }
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

    public function getUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            return Api::setResponse('user', $user);
        } else {
            return Api::setError('User not found');
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

            if ($request->has('fcm_token')) {
                $user->fcm_token = $request->fcm_token;
                $user->save();
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
        return Api::setResponse('users', $users);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:6',]
        ]);

        $currentPasswordStatus = Hash::check($request->password, auth()->user()->password);
        if ($currentPasswordStatus) {
            $user = User::find(auth()->user()->id);
            if (!$user) {
                return Api::setResponse('error', 'user not found');
            } else {
                $user->update(['password' => $request->new_password]);
                return Api::setResponse('success', 'Password updated');
            }
        } else {
            return Api::setError('Wrong current password');
        }
    }
}
