<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\IPAddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticationController::class, 'logout']);

    Route::get('authenticate', AuthenticatedUserController::class);

    Route::controller(UserProfileController::class)->group(function (){
        Route::get('me', 'index');
        Route::post('me', 'update');
    });

    // IP Address Routes
    Route::resource('ip-addresses', IPAddressController::class)->only([
        'index', 'store', 'show', 'update'
    ])->parameters(['ip-addresses' => 'id']);
});
