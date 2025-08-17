<?php

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\Auth\LogoutController;
use App\Http\Controllers\API\v1\Auth\PasswordController;
use App\Http\Controllers\API\v1\Auth\RegisterController;
use App\Http\Controllers\API\v1\Auth\EmailVerificationController;

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);
});

Route::prefix('/v1')->group(function () {
    Route::get('/health', function () {
        $client = Client::where('grant_types', 'like', '%password%')->first();;
        dd($client);
    })->name('v1.health');

    // Public Auth Routes
    Route::prefix('auth')->name('v1.auth.')->group(function () {
        Route::post('register', RegisterController::class)->name('register');
        Route::post('forgot-password', [PasswordController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('reset-password', [PasswordController::class, 'resetPassword'])->name('reset-password');
        Route::post('resend-verification-email', [EmailVerificationController::class, 'resendVerificationEmail'])->name('resend-verification-email');
        Route::post('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verifyEmailLink'])->middleware('signed')->name('verify-email');
    });

    // Protected Auth Routes
    Route::middleware(['auth:api', 'verified'])->prefix('auth')->name('v1.auth.')->group(function () {
        Route::post('logout', LogoutController::class)->name('logout');
    });

    Route::middleware(['auth:api', 'verified'])->group(function () {
        Route::middleware(['role:Admin | Super Admin'])->group(function () {
            Route::get('/admin', function (Request $request) {
                return $request->user();
            });
        });

        Route::middleware(['role:User'])->group(function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
        });

        Route::middleware(['role:Subscriber'])->group(function () {
            Route::get('/subscriber', function (Request $request) {
                return $request->user();
            });
        });
    });
});

