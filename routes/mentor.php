<?php

use App\Http\Controllers\Mentor\Talk\TalkController;
use Illuminate\Support\Facades\Route;

Route::middleware('role:mentor')->prefix('mentor')->as('mentor::')->group(function () {
   Route::resource('talk', TalkController::class);
});
