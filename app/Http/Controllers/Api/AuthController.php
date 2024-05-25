<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Api;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Mail\UserForgetPassword;
use App\Models\ForgetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    public function allUser()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
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


    public function forgetPassword(Request $request)
    {
        try {
            $existingOtp = ForgetPassword::where('email', $request->email)->first();
            if ($existingOtp) {
                $existingOtp->delete();
            }
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $mailData = [
                    'title' => 'MM-Telecom Forget Password',
                    'name' => $user->name,
                    'otp' => $otp,
                ];
                ForgetPassword::create([
                    'email' => $request->email,
                    'otp' => $otp
                ]);
                Mail::to($request->email)->send(new UserForgetPassword($mailData));

                return Api::setResponse('mail', 'OTP sent successfully');
            } else {
                return Api::setError('Account does not exist');
            }
        } catch (\Exception $e) {
            return Api::setError('An error occurred: ' . $e->getMessage());
        }
    }
    public function verifyOtp(Request $request)
    {
        $otp = ForgetPassword::where('otp', $request->otp)->first();
        if ($otp) {
            $otp->delete();
            return Api::setResponse('otp', 'matched');
        } else {
            return Api::setError('Invalid OTP');
        }
    }
    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->token = $user->createToken('auth_token')->plainTextToken;
            return Api::setResponse('user', $user);
        } else {
            return Api::setResponse('user', null);
        }
    }
    public function forgetupdatePassword(Request $request)
    {

        $data = User::where('email', $request->email)->first();

        $data->update([
            'password' => $request->password
        ]);

        return Api::setResponse('update', $data);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        if (isset($request->image))
            $user->update([
                'name' => $request->name,
                'image' => $request->image,
            ]);
        else
            $user->update([
                'name' => $request->name,
            ]);

        return Api::setResponse('user', $user);
    }
}
