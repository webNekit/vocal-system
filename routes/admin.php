<?php

use Illuminate\Support\Facades\Route;

Route::middleware('role:admin')->prefix('admin')->as('admin::')->group(function () {
    Route::resource('/user', \App\Http\Controllers\Admin\User\UserController::class);
    Route::resource('/assignment', \App\Http\Controllers\Admin\Assignment\AssignmentController::class);
});
