<?php

use App\Http\Controllers\Api\Admin\AuthController as ApiAdminAuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Libs\Roles;
use App\Http\Controllers\Api\User\AuthController as ApiUserAuthController;
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

Route::post('/admin/login', [ApiAdminAuthController::class, 'login']);
Route::post('/admin/logout', [ApiAdminAuthController::class, 'logout'])->middleware(['auth:sanctum', 'role:'.Roles::ADMIN]);

Route::post('/login', [ApiUserAuthController::class, 'login']);
Route::post('/register', [ApiUserAuthController::class, 'register']);
Route::post('/logout', [ApiUserAuthController::class, 'logout'])->middleware(['auth:sanctum', 'role:'.Roles::USER]);

Route::apiResource('posts', PostController::class);
