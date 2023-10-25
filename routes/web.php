<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// })->name('homepage');

Route::get('/', [HomeController::class, 'indexForUser'])->name('homepage');
Route::get('/posts', [PostController::class, 'indexForUser'])->middleware('userToken')->name('user-posts.index');
Route::get('/posts/{id}', [PostController::class, 'showForUser'])->middleware('userToken')->name('user-posts.show');
Route::get('/login', [UserAuthController::class, 'viewLogin'])->name('user.login');
Route::post('/login', [UserAuthController::class, 'login'])->name('user-form.login');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
Route::get('/register', [UserAuthController::class, 'viewRegister'])->name('user.register');
Route::post('/register', [UserAuthController::class, 'register'])->name('user-form.register');

Route::get('/admin', [HomeController::class, 'indexForAdmin'])->name('admin-dashboard');
Route::get('/admin/login', [AdminAuthController::class, 'viewLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin-form.login');
Route::get('/admin/posts', [PostController::class, 'indexForAdmin'])->middleware('adminToken')->name('admin-posts.index');
Route::post('/admin/posts', [PostController::class, 'store'])->middleware('adminToken')->name('admin-form.add');
Route::get('/admin/posts/add', [PostController::class, 'add'])->middleware('adminToken')->name('admin-posts.add');
Route::get('/admin/posts/{id}', [PostController::class, 'showForAdmin'])->middleware('adminToken')->name('admin-posts.show');
Route::get('/admin/posts/{id}/edit', [PostController::class, 'edit'])->middleware('adminToken')->name('admin-posts.edit');
Route::put('/admin/posts/{id}', [PostController::class, 'update'])->middleware('adminToken')->name('admin-form.edit');
Route::post('/admin/posts/{id}', [PostController::class, 'destroy'])->middleware('adminToken')->name('admin-posts.destroy');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
