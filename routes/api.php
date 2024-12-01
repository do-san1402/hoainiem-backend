<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return sendSuccessResponse('Okay','',200);
});

Route::controller(ApiController::class)->group(function () {

    Route::get('category-list', 'categoryList');
    Route::get('sidebar-categories', 'sidebarCategories');
    Route::get('home-page', 'homeData');
    Route::get('latest-post', 'latestPost');
    Route::get('populer-post', 'popularPost');
    Route::get('web-setting', 'webSetting');

    Route::get('post-detail/{encode_title}', 'newsDetails');
    Route::get('category-post/{slug}', 'categoryPost');

    Route::get('page-link', 'pageLink');
    Route::get('page-data/{slug}', 'pageData');
    Route::get('contact-us', 'contactUs');
    Route::get('topics-post/{tag}', 'tagPost');
    Route::get('trending-post', 'trendingPost');

    Route::get('tag-posts/{topic}', 'tagPost');
    Route::get('topic-posts/{topic}', 'topicPost');
    Route::post('archive-posts', 'archivePosts');
    Route::get('teams', 'ourTeam');

});

Route::post('user-post', [ApiController::class, 'userPost']);
Route::get('social-link', [ApiController::class, 'socialLink']);
Route::get('divisions', [ApiController::class, 'divisions']);
Route::get('districts/{id}', [ApiController::class, 'districts']);
Route::get('upazilas/{id}', [ApiController::class, 'upazilas']);
Route::post('search-post', [ApiController::class, 'postSearch']);
Route::get('photo-post', [ApiController::class, 'photoPosts']);
Route::get('photo-home', [ApiController::class, 'photoHomePosts']);
Route::get('xml-category-all', [ApiController::class, 'sitemapXmlCategory']);
Route::get('xml-category-post', [ApiController::class, 'sitemapXml']);
Route::get('metadata', [ApiController::class, 'metaAllData']);

Route::post('login', [ApiAuthController::class, 'login']);
Route::middleware('web')->get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::middleware('auth:api')->get('/check-auth', function (Request $request) {
    return response()->json([
        'authenticated' => true
    ]);
});
Route::middleware('auth:api')->get('/user/detail/{user_id}', [ApiUserController::class, 'get']);
Route::middleware('auth:api')->post('/user/update/{user_id}', [ApiUserController::class, 'update']);
Route::middleware('auth:api')->post('/posts', [PostController::class, 'store']);
Route::post('forgot-password', [ApiAuthController::class, 'sendResetLinkEmail']);
Route::post('register', [ApiAuthController::class, 'register']);
