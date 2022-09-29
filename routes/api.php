<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::resource('job-position', \App\Http\Controllers\JobPositionController::class);
Route::post('{job_position}/apply-for-job', [\App\Http\Controllers\JobPositionController::class, 'applyForJob']);
Route::post('new-project', [\App\Http\Controllers\NewProjectController::class, 'newProjectEmail']);

Route::middleware('auth:api')->group(function () {

    Route::prefix('admin')->middleware('scope:Manager,Admin')->group(function () {
        Route::resource('job-position', \App\Http\Controllers\Admin\JobPositionController::class);
        Route::resource('job-position-detail', \App\Http\Controllers\Admin\JobPositionDetailController::class);
        Route::get('order', [\App\Http\Controllers\Admin\JobPositionController::class,'orderDetails']);

    });

    Route::get('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

});
