<?php

use Illuminate\Support\Facades\Route;

Route::controller(ApiLoginController::class)->group(function () {
    Route::post('/login', 'App\Http\Controllers\ApiLoginController@validate');
});
