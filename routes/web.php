<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' =>['auth','role:super-admin|admin-Head']],function(){

    Route::resource('roles',RoleController::class)->middleware('permission:Access Role controller');

    Route::resource('permissions',PermissionController::class)->middleware('permission:Access Permission controller');

    Route::resource('users',UserController::class)->middleware('permission:Access User controller');
    // ->middleware('permission:access UserController');
});