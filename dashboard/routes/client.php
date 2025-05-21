<?php

use App\Http\Controllers\Settings\ClientController;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::post('client/generate', [ClientController::class, 'create'])->name('client.create');
    Route::post('client/refresh-secret', [ClientController::class, 'refresh'])->name('client.refresh');
});
