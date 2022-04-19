<?php

use App\Http\Controllers\API\PropertiController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\adminApiController;
use App\Http\Controllers\userApiController;
use Illuminate\Support\Facades\Route;

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

    Route::middleware('client')->group(function () {
        Route::post('/register', 'App\Http\Controllers\userApiController@register');
        Route::post('/login', 'App\Http\Controllers\userApiController@login');
        Route::post('/sorry', 'App\Http\Controllers\userApiController@sorry');

        Route::get('/properti', [PropertiController::class, 'properti']);
        Route::prefix('properti')->group(function () {
            Route::post('search', [PropertiController::class, 'search']);
            Route::post('search-sewa', [PropertiController::class, 'searchSewa']);
            Route::post('filter', [PropertiController::class, 'filter']);
            Route::post('filter-sewa', [PropertiController::class, 'filterSewa']);
        });

        Route::prefix('users')->group(function () {
            Route::get('profile/{id}', [UserController::class, 'profileUsers']);
            Route::post('{id}/verification', [UserController::class, 'verification']);
        });

        Route::post('/forgot-password', [adminApiController::class, 'forgotPass']);
        Route::post('/forgot-password/{id}/verificate', [adminApiController::class, 'forgotPassVer']);
        Route::post('/forgot-password/{id}/verificate/password', [adminApiController::class, 'forgotPassVerPass']);
        Route::get('/informasi', [adminApiController::class, 'informasi']);
        Route::get('/privasi', [adminApiController::class, 'privasi']);
        Route::get('/syarat', [adminApiController::class, 'syarat']);
        Route::get('/pesan-wa', [adminApiController::class, 'pesanWa']);
        Route::get('/tentang', [adminApiController::class, 'tentang']);
        Route::get('/faq', [adminApiController::class, 'faq']);
        Route::get('/customer-services', [adminApiController::class, 'customerServices']);
        Route::get('/faq/{id}/detail', [adminApiController::class, 'faq_detail']);
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('/kelola', [PropertiController::class, 'kelola']);
        Route::prefix('properti')->group(function () {
            Route::post('addfavorite', [PropertiController::class, 'addFavorite']);
            Route::post('delfavorite', [PropertiController::class, 'delFavorite']);
            Route::get('favorite/{id}', [PropertiController::class, 'favorite']);
            Route::post('tambah', [PropertiController::class, 'tambahPropertiPost']);
            Route::post('findfavorite', [PropertiController::class, 'findFav']);
            Route::get('{id}/detail', [PropertiController::class, 'detailProperti']);
            Route::post('{id}/edit', [PropertiController::class, 'editProperti']);
            Route::get('{id}/delete', [PropertiController::class, 'deleteProperti']);
        });

        Route::prefix('users')->group(function () {
            Route::post('request', [UserController::class, 'request']);
            Route::post('avatar', [UserController::class, 'avatar']);
            Route::post('password/ganti', [UserController::class, 'gantiPassword']);
            Route::post('findfavorite', [UserController::class, 'findUs']);
            Route::post('profile', [UserController::class, 'editProfile']);
            Route::post('profile/edit', [UserController::class, 'editProfilePost']);
            Route::post('addfavorite', [UserController::class, 'usersAddFavorite']);
            Route::post('delfavorite', [UserController::class, 'usersDelFavorite']);
            Route::get('favorite/{id}', [UserController::class, 'usersFavorite']);
        });

        Route::post('/voucher/insert', [adminApiController::class, 'voucher']);
        Route::get('/pengaturan/gambar/kategori', [adminApiController::class, 'gambar_kategori']);
        Route::get('/logout', [userApiController::class, 'logout']);
        Route::get('/profile', [userApiController::class, 'profile']);
    });
