<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PasswordRecoveryController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('v1/auth')->group(function () {
    Route::put('/register', 'create');
    Route::post('/login', 'login');
    Route::post('/resend_confirmation', 'resendAccountConfirmation');
    Route::post('/confirm_account', 'confirmAccount');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(PasswordRecoveryController::class)->prefix('v1/recovery_password')->group(function () {
    Route::post('/request_code', 'requestCode');
    Route::post('/recovery', 'recovery');
});

Route::controller(OrganizationController::class)->prefix('v1/organization')->middleware('auth:sanctum')->group(function () {
    Route::put('/create', 'create');
    Route::get('/get/{id}', 'get');
    Route::post('/update', 'update');
    Route::get('/getAll', 'getAllByLoggedUser');
    Route::post('/delete', 'delete');
});
