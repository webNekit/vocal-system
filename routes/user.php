<?php

use App\Http\Controllers\User\Talk\TalkController;
use Illuminate\Support\Facades\Route;

Route::middleware('role:user')->prefix('user')->as('user::')->group(function () {
    Route::resource('talks', TalkController::class);
});
