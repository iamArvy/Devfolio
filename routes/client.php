<?php

use App\Http\Controllers\Settings\ClientController;
use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::post('client/generate', [ClientController::class, 'create'])->name('settings.client.create');
    Route::post('client/refresh-secret', [ClientController::class, 'refresh'])->name('settings.client.refresh');
    Route::delete('client/delete', [ClientController::class, 'destroy'])->name('settings.client.destroy');
});
