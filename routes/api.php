<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\DocBelanjaPegawaiApiController;
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
Route::put('user/forgot-password/{email}',  [UserApiController::class, 'forgot']);

//========== DOCUMENT BELANJA PEGAWAI
Route::get('doc_belanja_pegawai/get', [DocBelanjaPegawaiApiController::class, 'get'])->middleware('jwt.verify');
Route::get('doc_belanja_pegawai/get/{id}', [DocBelanjaPegawaiApiController::class, 'show'])->middleware('jwt.verify');
Route::post('doc_belanja_pegawai/create', [DocBelanjaPegawaiApiController::class, 'store'])->middleware('jwt.verify');
Route::put('doc_belanja_pegawai/put/{id}', [DocBelanjaPegawaiApiController::class, 'put'])->middleware('jwt.verify');
Route::put('doc_belanja_pegawai/put_nofile/{id}', [DocBelanjaPegawaiApiController::class, 'put_nofile'])->middleware('jwt.verify');
Route::delete('doc_belanja_pegawai/delete/{id}',  [DocBelanjaPegawaiApiController::class, 'destroy'])->middleware('jwt.verify');
Route::get('doc_belanja_pegawai/download/{id}', [DocBelanjaPegawaiApiController::class, 'download']);
Route::get('combo/tahun_doc_keuangan', [DocBelanjaPegawaiApiController::class, 'comboTahun']);
Route::get('doc_belanja_pegawai/getchart', [DocBelanjaPegawaiApiController::class, 'getChart']);