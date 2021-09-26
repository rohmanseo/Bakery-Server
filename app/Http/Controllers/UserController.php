<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Rules\NotIncludeHtml;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $result = User::where('id',$user->id)->
        with(['subscription', 'subscription.class','role'])->first();
        return $this->responseWithItem($result);
    }

    public function changePassword(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'old_password' => ['required', new NotIncludeHtml],
            'password' => ['required','min:6','max:50','confirmed', new NotIncludeHtml]
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }


        $user = $request->user();
        $password = $request['old_password'];
        if (Hash::check($request['password'], $user->password)){
            return $this->responseWithError("Wrong password", self::$STATUS_WRONG_ARGUMENT);
        }

        if (Hash::check($password, $user->password)) {
            $user->update([
                'password' => bcrypt($request['password'])
            ]);
            return $this->responseSimpleSuccess();
        }

        return $this->responseWithError('Invalid Credentials', self::$STATUS_UNAUTHORIZED);
    }

    public function update(Request $request)
    {
        $validationData = Validator::make($request->all(), [
            'name' => ['required', 'min:5','max:30', new NotIncludeHtml],
            'address' => ['required','min:5','max:100', new NotIncludeHtml],
            'gender' => ['required','boolean', new NotIncludeHtml],
            'phone' => ['required','min:10','max:14', new NotIncludeHtml],
            'photo_profile' => ['url']
        ]);

        if ($validationData->fails()) {
            return $this->responseWithError($validationData->errors(), self::$STATUS_WRONG_ARGUMENT);
        }

        $data = $request->only([
            'name',
            'address',
            'gender',
            'phone',
            'photo_profile'
        ]);

        $user = $request->user();
        $user->update($data);
        return $this->responseWithItem($user);
    }
}
