<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
//========== USER
Route::post('login', [UserApiController::class, 'authenticate']);
Route::post('user/create', [UserApiController::class, 'store'])->middleware('jwt.verify');
Route::get('logout', [UserApiController::class, 'logout'])->middleware('jwt.verify');
Route::get('get_user', [UserApiController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');
Route::get('user/get', [UserApiController::class, 'get'])->middleware('jwt.verify');
Route::get('user/get/{id}', [UserApiController::class, 'show'])->middleware('jwt.verify');
Route::put('user/put/{user}', [UserApiController::class, 'update'])->middleware('jwt.verify');
Route::delete('user/delete/{user}',  [UserApiController::class, 'destroy'])->middleware('jwt.verify');