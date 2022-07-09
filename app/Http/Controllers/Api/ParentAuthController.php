<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\AuthRequest;
use Illuminate\Support\Arr;
use App\Models\ParentCh;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ParentAuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('auth.guard:parent_api', ['except' => ['login', 'register']]);
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->returnError(200, 'Login credentials are invalid.');
            }
        } catch (JWTException $e) {
            return $this->returnError(201, 'Could not create token.');
        }
        $parent = ParentCh::select('id as parent_id')->where('id', Auth::user()->id)->first();
        Arr::add($parent, 'token', $token);
        return $this->returnData('parent', $parent, 'success');
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return $this->returnSuccessMessage('User has been logged out');
        } catch (JWTException $exception) {
            return $this->returnError(200, 'Sorry, user cannot be logged out');
        }
    }

    public function refresh()
    {
        return $this->createNewToken(Auth::refresh());
    }

    public function userProfile()
    {
        return response()->json(Auth::user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->setTTL(60 * 24),
            'token' => $token,
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);

        $Parent = Auth::user();
        $ParentId = $Parent->id;

        if ($validator->fails()) {
            return $this->returnError($validator->errors());
        } else {
            $data = ParentCh::findOrFail($ParentId);
            $data->password = Hash::make($request->password);
            $data->save();
            return $this->returnSuccessMessage(' Password  changed successfully ');
        }
    }
}
