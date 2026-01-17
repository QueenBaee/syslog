<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DowntimeLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DeviceController::class, 'dashboard'])->name('dashboard');

Route::resource('devices', DeviceController::class);
Route::get('devices/{device}/print-logs', [DeviceController::class, 'printLogs'])->name('devices.print-logs');
Route::resource('devices.logs', DowntimeLogController::class)->shallow()->only(['store', 'update']);
