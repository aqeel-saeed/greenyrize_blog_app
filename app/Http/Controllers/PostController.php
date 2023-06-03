<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\NewsLetterEmail;
use App\Models\Post;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class PostController extends Controller {
    use ReturnResponse;
    public function index() {
        $posts = Post::query()
            ->select('title_' . request()->header('language') . ' as title')
            ->addSelect('content_' . request()->header('language') . ' as content')
            ->where('status', '=', 'accepted')
            ->addSelect('views')
            ->with('images');

        $title = request()->title;
        $user_id = \request()->user_id;
        $by_views = \request()->by_views;
        if (!is_null($title)) {
            $posts->where('title_' . request()->header('language'), 'like', "{$title}%");
        }
        if (!is_null($user_id)) {
            $posts->where('user_id', '=', $user_id);
        }
        if ($by_views == 1) {
            $posts->orderBy('views', 'desc');
        }

        $posts = $posts->get();

        return $this->returnData('data',$posts, 'Posts retrieved successfully.');
    }

    public function myPosts(Request $request) {
        $user = $request->user();

        $posts = Post::query()
            ->where('user_id', '=', $user->id)
            ->select('title_' . request()->header('language') . ' as title')
            ->addSelect('content_' . request()->header('language') . ' as content')
            ->with('images');

        return $this->returnData('data',$posts, 'Posts retrieved successfully.');
    }

    public function store(Request $request) {
        $input = $request->input();

        // writing the rules to validate register data
        $rules = [
            'title_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/|max:100',
            'title_ar' => 'required|string|max:255|regex:/^[\p{Arabic} ]+$/u|max:100',
            'content_en' => 'required|string|regex:/^[a-zA-Z& ]+$/|max:1500',
            'content_ar' => 'required|string|regex:/^[\p{Arabic} ]+$/u|max:1500',
            'encoded_images' => 'array',
            'encoded_images.*' => 'string',
            'categories' => 'required|array',
            'categories.*' => 'numeric|min:1|exists:categories,id',
        ];

        $errors = [
            // add custom message for the format error
            'title_en.regex' => 'The title_en must include only english letters.',
            'title_ar.regex' => 'The title_ar must include only arabic letters.',
            'content_en.regex' => 'The content_en must include only english letters.',
            'content_ar.regex' => 'The content_ar must include only arabic letters.',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $user = $request->user();

        $post = Post::create([
            'title_en' => $input['title_en'],
            'title_ar' =>  $input['title_ar'],
            'content_en' =>  $input['content_en'],
            'content_ar' =>  $input['content_ar'],
            'views' => 0,
            'user_id' => $user->id,
        ]);

        $categories = Category::whereIn('id', $input['categories'])->get();
        $post->categories()->attach($categories);

        $post->save();

        if (!isEmpty($input['encoded_images'])) {
            foreach ($input['encoded_images'] as $encoded_image) {
                $image = Image::create([
                    'encoded_image' => $encoded_image,
                    'post_id' => $post->id,
                ]);
                $image->save();
            }
        }

        $post = Post::query()
            ->find($post->id)
            ->with(['images', 'categories'])
            ->get();

        return $this->returnData('data',$post, 'Post created successfully.');
    }

    public function update(Request $request, $id) {
        $input = $request->input();

        // writing the rules to validate register data
        $rules = [
            'title_en' => 'required|string|max:255|regex:/^[a-zA-Z& ]+$/|max:100',
            'title_ar' => 'required|string|max:255|regex:/^[\p{Arabic} ]+$/u|max:100',
            'content_en' => 'required|string|regex:/^[a-zA-Z& ]+$/|max:1500',
            'content_ar' => 'required|string|regex:/^[\p{Arabic} ]+$/u|max:1500',
        ];

        $errors = [
            // add custom message for the format error
            'title_en.regex' => 'The title_en must include only english letters.',
            'title_ar.regex' => 'The title_ar must include only arabic letters.',
            'content_en.regex' => 'The content_en must include only english letters.',
            'content_ar.regex' => 'The content_ar must include only arabic letters.',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules, $errors);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $user = $request->user();
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->returnError(404, 'Post id is not valid.');
        }

        if ($user->id !== $post->user_id) {
            return $this->returnError(401, 'You are not the owner of this post.');
        }

        $post->update($input);

        return $this->returnSuccessMessage('Post deleted successfully.');
    }

    public function destroy(Request $request, $id) {
        $user = $request->user();
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->returnError(404, 'Post id is not valid.');
        }

        if (($user->id !== $post->user_id) && $user->role !== 'admin') {
            return $this->returnError(401, 'You are not the owner of this post, and you are not an admin.');
        }

        $post->delete();

        return $this->returnSuccessMessage('Post deleted successfully.');
    }

    public function indexUnderReviewPosts() {
        $posts = Post::query()
//            ->select('title_' . request()->header('language') . ' as title')
//            ->addSelect('content_' . request()->header('language') . ' as content')
            ->where('status', '=', 'under_review')
//            ->addSelect('views')
            ->with('images');

        $title = request()->title;
        if (!is_null($title)) {
            $posts->where('title_' . request()->header('language'), 'like', "{$title}%");
        }

        $posts = $posts->get();

        return $this->returnData('data',$posts, 'Under review posts retrieved successfully.');
    }

    public function updatePostStatus(Request $request, $id) {
        $input = $request->input();

        // writing the rules to validate register data
        $rules = [
            'status' => 'required|in:accepted,rejected',
        ];

        // validate register data with the previous rules
        $validator = Validator::make($input, $rules);

        // if validator fails, return all errors with details to know how to be valid
        if($validator->fails()){
            return $this->returnError(422, $validator->errors());
        }

        $post = Post::find($id);

        if (is_null($post)) {
            return $this->returnError(404, 'Post id is not valid.');
        }

        $post->update([
            'status' => $input['status'],
        ]);

        if ($input['status'] == 'accepted') {
            // email with the new post
            $mails = NewsLetterEmail::all();
            foreach ($mails as $mail) {
                Mail::to($mail['mail'])->send(new \App\Mail\Mail($input['title_en'], '', 'emails.newPostEmail'));
            }

            return $this->returnSuccessMessage('Post accepted successfully.');
        }

        return $this->returnSuccessMessage('Post rejected successfully.');
    }
}
