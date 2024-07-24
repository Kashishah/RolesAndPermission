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

Route::group(['middleware' =>['auth','role:Super-Admin|Admin|Staff|HR|test']],function(){

    Route::resource('roles',RoleController::class);

    Route::resource('permissions',PermissionController::class);

    Route::resource('users',UserController::class)->middleware('permission:access UserController');

});
// Route::delete('roles/{roleId}/delete',[RoleController::class, 'destroy'])->name('roles.delete');