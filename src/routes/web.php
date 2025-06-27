<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::get('/', function () {
    return redirect()->route('ads.index');
});

Route::resource('ads', AdController::class);
