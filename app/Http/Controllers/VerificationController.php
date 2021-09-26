<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerificationController extends BaseController
{
    public function __construct()
    {
//        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function resend(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }
        $user = User::where('email', $request['email'])->first();
        if (!isset($user)) {
            return $this->responseWithError('User does not exist', BaseController::$STATUS_MISSING);
        }

        if ($user->email_verified_at != null) {
            return $this->responseWithError('Already verified', BaseController::$STATUS_WRONG_ARGUMENT);
        }
        $user->sendEmailVerificationNotification();

//        $request->user()->sendEmailVerificationNotification();

        return $this->responseSimpleSuccess();
    }

    public function verify(Request $request)
    {
        auth()->loginUsingId($request->route('id'));

        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {

            return view('emails.already_verified');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect("https://test.biramamusik.id/verification-success");

    }
}
