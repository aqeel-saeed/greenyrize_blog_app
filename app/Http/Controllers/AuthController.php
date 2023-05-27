<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller {
    use ReturnResponse;

    public function signUp (Request $request) {
        // writing the rules to validate register data
        $rules = [
            'first_name_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'last_name_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'first_name_ar' => 'required|string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'last_name_ar' => 'required|string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone_number' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'role' => 'required|in:user,admin',
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
        $user['token'] = $user->createToken('access_token')->accessToken;
        auth()->login($user);

        return $this->returnData('user', $user, 'User registered successfully.');
    }

    public function logIn (Request $request) {

        $input = $request->all();
        $user = auth()->user();

        // writing the rules to validate register data
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required',
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

        return $this->returnData('user', $user, 'User login successfully');
    }

    public function logOut (Request $request) {
        // revoke the token
        $user = auth()->user();
        if ($user instanceof User){
            $user->token()->delete();
        }
        return $this->returnSuccessMessage('Logged out successfully.');
    }
}
