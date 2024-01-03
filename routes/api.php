<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
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

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'movie'], function () {
        Route::post('/create', [MovieController::class, 'store']);
        Route::post('/delete', [MovieController::class, 'destroy']);
        Route::post('/update', [MovieController::class, 'update']);
        Route::post('/get-data', [MovieController::class, 'data']);
    });
    Route::group(['prefix' => 'language'], function () {
        Route::post('/create', [LanguageController::class, 'store']);
        Route::post('/delete', [LanguageController::class, 'destroy']);
        Route::post('/update', [LanguageController::class, 'update']);
        Route::post('/get-data', [LanguageController::class, 'data']);
    });
    Route::group(['prefix' => 'episode'], function () {
        Route::post('/create', [EpisodeController::class, 'store']);
        Route::post('/delete', [EpisodeController::class, 'destroy']);
        Route::post('/update', [EpisodeController::class, 'update']);
        Route::post('/get-data', [EpisodeController::class, 'data']);
    });
    Route::group(['prefix' => 'author'], function () {
        Route::post('/create', [AuthorController::class, 'store']);
        Route::post('/delete', [AuthorController::class, 'destroy']);
        Route::post('/update', [AuthorController::class, 'update']);
        Route::post('/get-data', [AuthorController::class, 'data']);
    });
    Route::group(['prefix' => 'country'], function () {
        Route::post('/create', [CountryController::class, 'store']);
        Route::post('/delete', [CountryController::class, 'destroy']);
        Route::post('/update', [CountryController::class, 'update']);
        Route::post('/get-data', [CountryController::class, 'data']);
    });
    Route::group(['prefix' => 'type'], function () {
        Route::post('/create', [TypeController::class, 'store']);
        Route::post('/delete', [TypeController::class, 'destroy']);
        Route::post('/update', [TypeController::class, 'update']);
        Route::post('/get-data', [TypeController::class, 'data']);
    });
    Route::group(['prefix' => 'client'], function () {
        Route::post('/create', [ClientController::class, 'store']);
        Route::post('/delete', [ClientController::class, 'destroy']);
        Route::post('/update', [ClientController::class, 'update']);
        Route::post('/get-data', [ClientController::class, 'data']);
    });
    Route::group(['prefix' => 'employee'], function () {
        Route::post('/create', [EmployeeController::class, 'store']);
        Route::post('/delete', [EmployeeController::class, 'destroy']);
        Route::post('/update', [EmployeeController::class, 'update']);
        Route::post('/get-data', [EmployeeController::class, 'data']);
    });
});
