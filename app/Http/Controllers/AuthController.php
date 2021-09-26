<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\NotIncludeHtml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{

    public function register(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'name' => ['required', 'min:5', 'max:30', new NotIncludeHtml],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'max:30', 'confirmed'],
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }

        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        return $this->responseWithItem($user);
    }

    public function login(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required']
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }

        if (!auth()->attempt($request->all())) {
            return $this->responseWithError('Invalid Credentials', self::$STATUS_UNAUTHORIZED);
        }
        $user = auth()->user();

        $token = $user->createToken('authToken')->accessToken;
        $user['token'] = $token;
        return $this->responseWithItem($user);
    }

    public function profile(Request $request){
        $user = Auth::user();
        return $this->responseWithItem($user);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->token()->revoke();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function checkEmail(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'email' => ['required'],
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }

        $user = User::where('email', $request->email)->first();

        return $this->responseWithItem([
            'exist' => $user != null
        ]);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        $token = $user->createToken('authToken')->accessToken;
        $user['token'] = $token;

        return $this->responseWithItem($user);

    }
}
