<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            /** @var \App\Models\User $authUser */
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyApi')->plainTextToken;
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'User Logined In Successfully');
        }

        return $this->sendError('Unauthorized.', ['error' => 'Invalid credentials'], 401);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken('MyApi')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'Registration Successful', 200);
    }
}
