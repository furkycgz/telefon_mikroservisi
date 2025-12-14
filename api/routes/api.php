<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\RegistrationController;

// Laravel already prefixes this file with /api; define plain paths here.
Route::post('/phone/validate', [PhoneController::class, 'validateNumber']);
Route::get('/phone/count', [PhoneController::class, 'count']);
Route::post('/registration', [RegistrationController::class, 'store']);
