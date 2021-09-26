<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreadController;
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
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/checkEmail', [AuthController::class, 'checkEmail']);
Route::get('/auth/profile', [AuthController::class, 'profile'])->middleware('auth:api');
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/breads/popular', [BreadController::class, 'getPopular'])->middleware('auth:api');
Route::get('/breads/recent', [BreadController::class, 'getBreads'])->middleware('auth:api');

