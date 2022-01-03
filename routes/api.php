<?php

use Illuminate\Http\Request;
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
        Route::get('/properti/filter', 'App\Http\Controllers\adminApiController@filter');
        Route::post('/properti/filter-sewa', 'App\Http\Controllers\adminApiController@filterSewa');
        Route::post('/register', 'App\Http\Controllers\userApiController@register');
        Route::post('/login', 'App\Http\Controllers\userApiController@login');
        Route::post('/sorry', 'App\Http\Controllers\userApiController@sorry');
        Route::get('/properti', [App\Http\Controllers\adminApiController::class, 'properti']);
        Route::post('/properti/search', 'App\Http\Controllers\adminApiController@search');
        Route::post('/properti/search-sewa', 'App\Http\Controllers\adminApiController@searchSewa');
        Route::post('/users/{id}/verification', [App\Http\Controllers\adminApiController::class, 'verification']);
        Route::post('/forgot-password', 'App\Http\Controllers\adminApiController@forgotPass');
        Route::post('/forgot-password/{id}/verificate', 'App\Http\Controllers\adminApiController@forgotPassVer');
        Route::post('/forgot-password/{id}/verificate/password', 'App\Http\Controllers\adminApiController@forgotPassVerPass');
        Route::get('/informasi', 'App\Http\Controllers\adminApiController@informasi');
        Route::get('/privasi', [App\Http\Controllers\adminApiController::class, 'privasi']);
        Route::get('/syarat', [App\Http\Controllers\adminApiController::class, 'syarat']);
        Route::get('/pesan-wa', [App\Http\Controllers\adminApiController::class, 'pesanWa']);
        Route::get('/tentang', [App\Http\Controllers\adminApiController::class, 'tentang']);
        Route::get('/faq', [App\Http\Controllers\adminApiController::class, 'faq']);
        Route::get('/customer-services', [App\Http\Controllers\adminApiController::class, 'customerServices']);
        Route::get('/faq/{id}/detail', [App\Http\Controllers\adminApiController::class, 'faq_detail']);
        Route::get('/users/profile/{id}', [App\Http\Controllers\adminApiController::class, 'profileUsers']);
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('/users/password/ganti', 'App\Http\Controllers\adminApiController@gantiPassword');
        Route::post('/voucher/insert', 'App\Http\Controllers\adminApiController@voucher');
        Route::get('/logout', 'App\Http\Controllers\userApiController@logout');
        Route::post('/users/request', [App\Http\Controllers\adminApiController::class, 'request']);
        Route::post('/users/avatar', [App\Http\Controllers\adminApiController::class, 'avatar']);
        Route::get('/profile', 'App\Http\Controllers\userApiController@profile');
        Route::get('/properti/{id}/detail', [App\Http\Controllers\adminApiController::class, 'detailProperti']);
        Route::post('/properti/{id}/edit', 'App\Http\Controllers\adminApiController@editProperti');
        Route::get('/properti/{id}/delete', 'App\Http\Controllers\adminApiController@deleteProperti');
        Route::get('/pengaturan/gambar/kategori', [App\Http\Controllers\adminApiController::class, 'gambar_kategori']);
        Route::post('/properti/addfavorite', 'App\Http\Controllers\adminApiController@addFavorite');
        Route::post('/properti/delfavorite', 'App\Http\Controllers\adminApiController@delFavorite');
        Route::get('/properti/favorite/{id}', 'App\Http\Controllers\adminApiController@favorite');
        Route::post('/properti/tambah', [App\Http\Controllers\adminApiController::class, 'tambahPropertiPost']);
        Route::post('/kelola', 'App\Http\Controllers\adminApiController@kelola');
        Route::post('/properti/findfavorite', 'App\Http\Controllers\adminApiController@findFav');
        Route::post('/users/findfavorite', 'App\Http\Controllers\adminApiController@findUs');
        Route::post('/users/profile', 'App\Http\Controllers\adminApiController@editProfile');
        Route::post('/users/profile/edit', 'App\Http\Controllers\adminApiController@editProfilePost');
        Route::post('/users/addfavorite', 'App\Http\Controllers\adminApiController@usersAddFavorite');
        Route::post('/users/delfavorite', 'App\Http\Controllers\adminApiController@usersDelFavorite');
        Route::get('/users/favorite/{id}', 'App\Http\Controllers\adminApiController@usersFavorite');
    });
