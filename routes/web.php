<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile-store', [ProfileController::class, 'profileStore'])->name('profile-store');
Route::post('/password-store', [ProfileController::class, 'passwordStore'])->name('password-store');
Route::post('/foto-store', [ProfileController::class, 'fotoStore'])->name('foto-store');
Route::get('/del-foto', [ProfileController::class, 'deleteFoto'])->name('del-foto');

// user
Route::resource('user', UserController::class);
Route::get('/list-user', [UserController::class, 'list'])->name('list-user');