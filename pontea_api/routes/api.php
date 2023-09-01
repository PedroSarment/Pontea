<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckToken;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AgeGroupController;
use App\Http\Controllers\LevelController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::controller(AuthController::class)->group(function () {

    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware(CheckToken::class)->group(function () {


    });
});

Route::controller(ActivitiesController::class)->group(function () {

    Route::prefix('activity')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/filter', 'filter');
            Route::get('/{id}', 'show');

        });
    });
});

Route::controller(AreaController::class)->group(function () {

    Route::prefix('area')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
        });
    });
});

Route::controller(TeacherController ::class)->group(function () {

    Route::prefix('teacher')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
        });
    });
});

Route::controller(AgeGroupController ::class)->group(function () {

    Route::prefix('age_group')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
        });
    });
});

Route::controller(LevelController ::class)->group(function () {

    Route::prefix('levels')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
        });
    });
});

/* Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout'); */
