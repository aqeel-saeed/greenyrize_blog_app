<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ReturnResponse;
use Illuminate\Http\Request;

class PostController extends Controller {
    use ReturnResponse;
    public function index() {
        // Todo: add search by title.
        $posts = Post::query();

        return $this->returnData(200, $posts, 'posts');
    }

    public function myPosts() {

    }
}
