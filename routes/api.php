<?php

use App\Http\Controllers\AuditLog\AuditLogController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\AuthenticationLog\AuthenticationLogController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\IPAddress\IPAddressController;
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

// ================================LOGIN ROUTE================================
// Applied Rate Limiting to the API.
// Maximum 3 Requests in One minute
Route::post(
    'login',
    [AuthenticationController::class, 'login']
)->middleware('throttle:3,1');

// ================================AUTHENTICATED ROUTES================================

Route::middleware('auth:sanctum')->group(function () {
    Route::post(
        'logout',
        [AuthenticationController::class, 'logout']
    );

    Route::get(
        'authenticate',
        AuthenticatedUserController::class
    );

    // ================================Authentication Log Routes================================
    Route::controller(AuthenticationLogController::class)->group(function () {
        Route::get(
            'authentication-logs',
            'index'
        );
    });

    // ================================USER PROFILE ROUTES================================
    Route::controller(UserProfileController::class)->group(function () {
        Route::get(
            'me',
            'index'
        );

        Route::post(
            'me',
            'update'
        );
    });


    // ================================IP Address Routes================================
    Route::resource(
        'ip-addresses',
        IPAddressController::class
    )->only([
        'index', 'store', 'show', 'edit', 'update'
    ])->parameters(['ip-addresses' => 'id']);


    // ================================Dashboard Routes================================
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function(){
        Route::get('overview', 'overview');
        Route::get('recent-logins', 'get_recent_login');
    });


    // ================================Audit Log Routes================================
    Route::controller(AuditLogController::class)->group(function () {
        Route::get(
            'audit-logs',
            'index'
        );
    });
    
});
