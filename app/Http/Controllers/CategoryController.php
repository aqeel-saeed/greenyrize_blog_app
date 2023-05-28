<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    use ReturnResponse;
    public function index(Request $request) {
        $categories = Category::query()
            ->select('name_' . request()->header('language') . ' as name')
            ->addSelect('description_' . request()->header('language') . ' as description')
            ->addSelect('encoded_image');

        $name = request()->name;
        if (!is_null($name)) {
            $categories->where('name_' . request()->header('language'), 'like', "{$name}%");
        }

        $categories = $categories->get();

        return $this->returnData('data',$categories, 'Categories retrieved successfully.');
    }

    public function store(Request $request) {
        $input = $request->input();

        // writing the rules to validate register data
        $rules = [
            'name_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'name_ar' => 'required|string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'description_en' => 'required|string|regex:/^[a-zA-Z& ]+$/|between:30,600',
            'description_ar' => 'required|string|regex:/^[\p{Arabic} ]+$/u|between:30,600',
            'encoded_image' => 'required|string',
        ];

        $errors = [
            // add custom message for the format error
            'name_en.regex' => 'The name_en must include only english letters.',
            'name_ar.regex' => 'The name_en must include only arabic letters.',
            'description_en.regex' => 'The description_en must include only english letters.',
            'description_ar.regex' => 'The description_ar must include only arabic letters.',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $category = Category::create($input);

        return $this->returnData('data', $category, 'Category created successfully.');
    }

    public function show($id) {
        $category = Category::query()
            ->where('id', $id)
            ->select('name_' . request()->header('language') . ' as name')
            ->addSelect('description_' . request()->header('language') . ' as description')
            ->addSelect('encoded_image')
            ->first();

        if(is_null($category)) {
            return $this->returnError(404, 'Category id is not valid.');
        }

        return $this->returnData('data',$category, 'Categories retrieved successfully.');
    }

    public function update(Request $request, $id) {
        // writing the rules to validate register data
        $rules = [
            'name_en' => 'string|max:255|regex:/^[a-zA-Z& ]+$/',
            'name_ar' => 'string|max:255|regex:/^[\p{Arabic} ]+$/u',
            'description_en' => 'string|regex:/^[a-zA-Z& ]+$/|between:30,600',
            'description_ar' => 'string|regex:/^[\p{Arabic} ]+$/u|between:30,600',
            'encoded_image' => 'string',
        ];

        $errors = [
            // add custom message for the format error
            'name_en.regex' => 'The name_en must include only english letters.',
            'name_ar.regex' => 'The name_en must include only arabic letters.',
            'description_en.regex' => 'The description_en must include only english letters.',
            'description_ar.regex' => 'The description_ar must include only arabic letters.',
        ];

        $input = $request->all();

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $category = Category::find($id);

        if(is_null($category)) {
            return $this->returnError(404, 'Category id is not valid.');
        }

        $category->update($input);

        return $this->returnData('data', $category, 'Category updated successfully.');
    }

    public function destroy(string $id) {
        $category = Category::find($id);
        if(is_null($category)) {
            return $this->returnError(404, 'Category id is not valid.');
        }

        $category->delete();

        return $this->returnSuccessMessage('Category deleted successfully.');
    }
}
