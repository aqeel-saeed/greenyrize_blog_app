<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller {
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => 'true',
            'data' =>  $categories ,
            'message' => 'Categories retrieved successfully'
        ], 200);

    }

    public function store(Request $request)
    {
        $categories = $request->all();

        // writing the rules to validate register data
        $rules = [
            'name_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'name_ar' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'description_en' => 'required|string|between:30,600',
            'description_ar' => 'required|string|between:30,600',
            'encoded_image' => 'required|string|max:255',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($categories, $rules);


        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }

        $category = Category::create($categories);

        return response()->json([
            'success' => 'true',
            'data' =>  $categories ,
            'message' => 'Category created successfully'
        ], 200);

    }

    public function show(string $id)
    {
        $category = Category::find($id);
        if(!$category)
            return response()->json([
                'success' => 'false',
                'message' => 'Category not found.'
            ]);
        return response()->json([
            'success' => 'true',
            'data' =>  $categories
        ], 200);

    }



    public function update(Request $request,string $id )
    {
        $category = Category::find($id);

        // writing the rules to validate register data
        $rules = [
            'name_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'name_ar' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/',
            'description_en' => 'required|string|between:30,600',
            'description_ar' => 'required|string|between:30,600',
            'encoded_image' => 'required|string|max:255',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($category, $rules);


        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()) {
            return response(['error' => $validator->errors(),
                'Validation Error']);
        }
        if(!$category)
            return response()->json([
                'success' => 'false',
                'message' => 'Category not found.'
            ]);

        $category->update($request->all());
        return response()->json([
            'success' => 'true',
            'message' => 'Category updated successfully'

        ], 200);

    }

    public function destroy(string $id)
    {

        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'success' => 'true',
            'message' => 'Category deleted successfully.'

        ], 200);
    }
}
