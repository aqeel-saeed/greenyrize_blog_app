<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SendMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'logIn']);
Route::get('/logout', [AuthController::class, 'logOut'])->middleware('auth:api');

Route::group([
    'prefix' => '/categories',
], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});
Route::group([
    'prefix' => '/posts',
], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::get('/', [PostController::class, 'myPosts']);
    Route::post('/', [PostController::class, 'store']);
    Route::put('/{id}', [PostController::class, 'update']);
    Route::delete('/{id}', [PostController::class, 'destroy']);
    Route::get('/', [PostController::class, 'indexUnderReviewPosts']);
    Route::put('/{id}', [PostController::class, 'updatePostStatus']);
});

Route::group([
    'prefix' => '/profiles',
], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('/{id}', [ProfileController::class, 'show']);
    Route::put('/{id}', [ProfileController::class, 'update']);
    Route::delete('/{id}', [ProfileController::class, 'destroy']);
    Route::delete('/', [ProfileController::class, 'destroyMyProfile']);
});

Route::post('/sendMail', [SendMailController::class, 'send']);
Route::post('/email', [EmailController::class, 'send']);
