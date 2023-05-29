<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    use ReturnResponse;
    public function index(Request $request) {
        $profiles = User::all();
    }

    public function store(Request $request) {

        $rules = [
            'first_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'last_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'first_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'last_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'email' => 'string|email|unique:users|max:255',
            'password' => 'string|min:8|max:255|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone_number' => 'numeric',
            'gender' => 'in:male,female',
            'role' => 'in:user,admin',
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
        $input['password'] = Hash::make($input['password']);

        // validate update data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $profile = User::find($id);

        if(is_null($profile)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $profile->create($input);

        return $this->returnData('Profile stored successfully.');
    }

    public function show($id) {
        $profile = User::find($id);

        if(is_null($profile)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $profile->get();
        return $this->returnSuccessMessage('Profile show successfully.');
    }

    public function update(Request $request, $id) {
        // writing the rules to validate update data
        $rules = [
            'first_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'last_name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'first_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'last_name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'email' => 'string|email|unique:users|max:255',
            'password' => 'string|min:8|max:255|confirmed|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'phone_number' => 'numeric',
            'gender' => 'in:male,female',
            'role' => 'in:user,admin',
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
        $input['password'] = Hash::make($input['password']);

        // validate update data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $profile = User::find($id);

        if(is_null($profile)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $profile->update($input);

        return $this->returnData('Profile updated successfully.');
    }

    public function destroy($id) {
        $profile = User::find($id);
        if(is_null($profile)) {
            return $this->returnError(404, 'Profile id is not valid.');
        }

        $profile->delete();

        return $this->returnSuccessMessage('Profile deleted successfully.');
    }
}
