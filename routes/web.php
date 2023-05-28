<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// master user
Route::resource('user', UserController::class);
Route::get('/list-user', [UserController::class, 'list'])->name('list-user');

// master role
Route::resource('role', RoleController::class);
Route::get('/list-role', [RoleController::class, 'listRole'])->name('list-role');

// master project
Route::resource('project', ProjectController::class);
Route::get('/list-project', [ProjectController::class, 'listproject'])->name('list-project');

// schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
Route::get('/schedule/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
Route::get('/list-schedule', [ScheduleController::class, 'listschedule'])->name('list-schedule');
Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
Route::get('/schedule/done', [ScheduleController::class, 'done'])->name('schedule.done');

// activity (progres)
Route::get('/activity', [ActivityController::class, 'index'])->name('activity');
Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
Route::get('/list-activity/{id}', [ActivityController::class, 'listactivity'])->name('list-activity');