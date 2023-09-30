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
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CommentController;

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

        Route::get('/profile', 'profile');
        Route::get('/removeCredit', 'removeCredit');
    });
});

Route::controller(ActivitiesController::class)->group(function () {

    Route::prefix('activity')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/filter', 'filter');
            Route::post('/store', 'store');
            Route::put('/update/{id}', 'update');

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
            Route::get('/turn_user_into_teacher', 'turnUserIntoTeacher');
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

Route::controller(ShoppingCartController ::class)->group(function () {

    Route::prefix('shopping_carts')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::post('/remove', 'remove');
            Route::delete('/destroy', 'destroy');
        });
    });
});

Route::controller(PurchaseController ::class)->group(function () {

    Route::prefix('purchase')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::post('/', 'purchase');
        });
    });
});

Route::controller(QuestionController::class)->group(function () {

    Route::prefix('question')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::post('/store', 'store');
            Route::post('/responds', 'responds');
            Route::post('/like', 'like');

        });
    });
});

Route::controller(CommentController::class)->group(function () {

    Route::prefix('comment')->group(function () {

        Route::middleware(CheckToken::class)->group(function () {
            Route::post('/store', 'store');
        });
    });
});
