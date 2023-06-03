<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller {
    use ReturnResponse;

    public function index() {
        $profiles = User::query();

        $name = \request()->name;
        if (!is_null($name)) {
            $profiles
                ->where('first_name_' . request()->header('language'), 'like', "{$name}%")
                ->orWhere('last_name_' . request()->header('language'), 'like', "{$name}%");
        }

        $profiles = $profiles->get();

        return $this->returnData('data',$profiles, 'Profiles retrieved successfully.');
    }

    public function show($id) {
        $profile = User::find($id);

        if(is_null($profile)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $profile->get();

        return $this->returnSuccessMessage('Profile showed successfully.');
    }

    public function update(Request $request) {
        // writing the rules to validate update data
        $rules = [
            'first_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'last_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'first_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'last_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'password' => 'string|min:8|max:255|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone_number' => 'string|numeric',
        ];

        $errors = [
            // add custom message for the format error
            'first_name_en.regex' => 'The first_name_en must include only english letters.',
            'first_name_ar.regex' => 'The first_name_ar must include only arabic letters.',
            'last_name_en.regex' => 'The last_name_en must include only english letters.',
            'last_name_ar.regex' => 'The last_name_ar must include only arabic letters.',
            'password.regex' => 'The password must include letters, numbers, and special symbols.',
        ];

        $input = $request->all();

        if (!is_null($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }

        // validate update data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

//        $profile = User::find($id);
        $user = $request->user();

        $user->update($input);

        return $this->returnData('user', $user, 'Profile updated successfully.');
    }

    public function destroy($id) {
        $user = User::find($id);
        if(is_null($user)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $user->delete();

        return $this->returnSuccessMessage('Profile deleted successfully.');
    }

    public function destroyMyProfile(Request $request) {
        $user = $request->user();

        $user->delete();

        return $this->returnSuccessMessage('Profile deleted successfully.');
    }
}
