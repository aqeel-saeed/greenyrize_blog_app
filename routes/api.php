<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::post('/signup', [AuthController::class, 'signUp'])->middleware(['auth:api', 'admin']);
Route::post('/login', [AuthController::class, 'logIn']);
Route::get('/logout', [AuthController::class, 'logOut'])->middleware('auth:api');

Route::group([
    'prefix' => '/categories',
], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store'])->middleware(['auth:api', 'admin']);
    Route::put('/{id}', [CategoryController::class, 'update'])->middleware(['auth:api', 'admin']);
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware(['auth:api', 'admin']);
});

Route::post('/sendMail', [SendMailController::class, 'send'])->middleware(['auth:api', 'admin']);

Route::group([
    'prefix' => '/posts',
], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/{id}', [PostController::class, 'show']);
    Route::get('/myPosts', [PostController::class, 'myPosts'])->middleware('auth:api');
    Route::post('/', [PostController::class, 'store'])->middleware('auth:api');
    Route::put('/{id}', [PostController::class, 'update'])->middleware('auth:api');
    Route::delete('/{id}', [PostController::class, 'destroy'])->middleware('auth:api');
    Route::get('/underReview', [PostController::class, 'indexUnderReviewPosts'])->middleware(['auth:api', 'admin']);
    Route::put('/updateStatus/{id}', [PostController::class, 'updatePostStatus'])->middleware(['auth:api', 'admin']);
});

Route::group([
    'prefix' => '/profiles',
], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::get('/{id}', [ProfileController::class, 'show']);
    Route::put('/{id}', [ProfileController::class, 'update'])->middleware('auth:api');
    Route::delete('/{id}', [ProfileController::class, 'destroy'])->middleware(['auth:api', 'admin']);
    Route::delete('/deleteMyAccount', [ProfileController::class, 'destroyMyProfile'])->middleware('auth:api');
});

Route::group([
    'prefix' => '/emails',
], function () {
    Route::get('/', [EmailController::class, 'index'])->middleware(['auth:api', 'admin']);
    Route::post('/', [EmailController::class, 'store']);
    Route::get('/{id}', [EmailController::class, 'show'])->middleware(['auth:api', 'admin']);
    Route::put('/{id}', [EmailController::class, 'update'])->middleware(['auth:api', 'admin']);
    Route::delete('/{id}', [EmailController::class, 'destroy'])->middleware(['auth:api', 'admin']);
});
