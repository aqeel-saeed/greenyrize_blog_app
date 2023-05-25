<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller {

    public function signUp (Request $request) {
        // writing the rules to validate register data
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        ];

        // validate register data with the previous rules
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        // if validator fails, return all errors with details to know how to be valid
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->all(),
                422
            );
        }

        // encrypting the pass by hashing
        $input['password'] = Hash::make($input['password']);

        // creating a user
        $user = new User();
        $user->fill($input);
        $user->save();

        // add token to the user
//        $tokenResult = $user->createToken('Personal Access Token');
        $user['token'] = $user->createToken('access_token')->accessToken;
        auth()->login($user);

        return response()->json([
            'user' => $user,
        ],  200);
    }

    public function logIn (Request $request) {

        $input = $request->all();
        $user = auth()->user();

        // writing the rules to validate register data
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules);

        // if validator fails, return all errors with details to know how to be valid
        if ($validator->fails()) {
            return response()->json(
                $validator->errors()->all(),
                422
            );
        }

        $input = request(['email', 'password']);
        if (!auth()->attempt($input)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth()->user();
        if ($user instanceof User) {
            $user['token'] = $user->createToken('access_token')->accessToken;
        }

        return response()->json([
            'message' => 'User login successfully',
            'user' => $user,
        ]);
    }

    public function logOut (Request $request) {
        // revoke the token
        $user = auth()->user();
        if ($user instanceof User){
            $user->token()->delete();
        }
        return \response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
