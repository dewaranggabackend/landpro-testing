<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sorry', 'App\Http\Controllers\adminController@sorry');
Route::get('/request-otp', [App\Http\Controllers\adminController::class, 'requestOTP']);
Route::post('/request-otp', [App\Http\Controllers\adminController::class, 'requestOTPost']);
Route::post('/request-otp/{id}/verification', [App\Http\Controllers\adminController::class, 'requestOTPostVer']);
Route::get('/lupa-password', [App\Http\Controllers\adminController::class, 'lupaPassword']);
Route::post('/lupa-password', [App\Http\Controllers\adminController::class, 'lupaPasswordPost']);
Route::post('/users/{id}/forgot', [App\Http\Controllers\adminController::class, 'lupaPasswordSet']);
Route::post('/users/{id}/forgot/password', [App\Http\Controllers\adminController::class, 'lupaPasswordSetPassword']);
Route::post('/users/{id}/verification', [App\Http\Controllers\adminController::class, 'verificationOTP']);

Route::group(['middleware' => ['auth', 'CekRole:1']], function () {
    Route::get('/properti/expire/fresh', [App\Http\Controllers\adminController::class, 'fresh']);
    Route::get('/informasi', [App\Http\Controllers\adminController::class, 'informasi']);
    Route::get('/informasi/search', [App\Http\Controllers\adminController::class, 'searchInformasi']);
    Route::get('/informasi/tambah', [App\Http\Controllers\adminController::class, 'tambahInformasi']);
    Route::post('/informasi/tambah', [App\Http\Controllers\adminController::class, 'tambahInformasiPost']);
    Route::get('/informasi/{id}', [App\Http\Controllers\adminController::class, 'detailInformasi']);
    Route::get('/informasi/{id}/hapus', [App\Http\Controllers\adminController::class, 'hapusInformasi']);
    Route::get('/informasi/{id}/edit', [App\Http\Controllers\adminController::class, 'editInformasi']);
    Route::post('/informasi/{id}/edit', [App\Http\Controllers\adminController::class, 'editInformasiPost']);
    Route::get('/properti/nonaktif/search', [App\Http\Controllers\adminController::class, 'searchPropertiTrashed']);
    Route::get('/properti/search', [App\Http\Controllers\adminController::class, 'searchProperti']);
    Route::get('/users/request/search', 'App\Http\Controllers\adminController@requestSearch');
    Route::get('/users/{id}/request/setuju', 'App\Http\Controllers\adminController@setujuRequest');
    Route::get('/users/{id}/request/tolak', 'App\Http\Controllers\adminController@tolakRequest');
    Route::get('/users/request', 'App\Http\Controllers\adminController@request');
    Route::get('/admin/kategori', 'App\Http\Controllers\adminController@category');
    Route::get('/properti/tambah', [App\Http\Controllers\adminController::class, 'tambahProperti']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/kategori', [App\Http\Controllers\adminController::class, 'category']);
    Route::get('/users', [App\Http\Controllers\adminController::class, 'users']);
    Route::get('/users/export', [App\Http\Controllers\adminController::class, 'userExcel']);
    Route::get('/users/search', [App\Http\Controllers\adminController::class, 'usersSearch']);
    Route::get('/users/{id}/ban', [App\Http\Controllers\adminController::class, 'banned']);
    Route::get('/users/banned', [App\Http\Controllers\adminController::class, 'viewban']);
    Route::get('/users/banned/search', [App\Http\Controllers\adminController::class, 'bannedSearch']);
    Route::get('/users/{id}/unban', [App\Http\Controllers\adminController::class, 'unban']);
    Route::get('/users/{id}/upgrade', [App\Http\Controllers\adminController::class, 'upgrade']);
    Route::get('/users/{id}/downgrade', [App\Http\Controllers\adminController::class, 'downgrade']);
    Route::get('/users/{id}/hapus', [App\Http\Controllers\adminController::class, 'hapus']);
    Route::get('/properti', [App\Http\Controllers\adminController::class, 'properti']);
    Route::get('/properti/export', [App\Http\Controllers\adminController::class, 'propertiExcel']);
    Route::post('/properti/tambah', [App\Http\Controllers\adminController::class, 'tambahPropertiPost']);
    Route::get('/properti/expire', [App\Http\Controllers\adminController::class, 'propertiExpire']);
    Route::get('/properti/{id}/stop',  [App\Http\Controllers\adminController::class, 'propertiStop']);
    Route::get('/properti/{id}/off',  [App\Http\Controllers\adminController::class, 'off']);
    Route::get('/properti/nonaktif', [App\Http\Controllers\adminController::class, 'nonaktif']);
    Route::get('/properti/{id}/on', [App\Http\Controllers\adminController::class, 'aktif']);
    Route::get('/properti/{id}/hapus', [App\Http\Controllers\adminController::class, 'hapusProperti']);
    Route::get('/properti/{id}/detail', [App\Http\Controllers\adminController::class, 'detailProperti']);
    Route::get('/privacy', [App\Http\Controllers\adminController::class, 'privacy']);
    Route::get('/privacy/{id}/edit', [App\Http\Controllers\adminController::class, 'privacyEdit']);
    Route::post('/privacy/{id}/edit', [App\Http\Controllers\adminController::class, 'privacyPost']);
    Route::get('/voucher', [App\Http\Controllers\adminController::class, 'voucher']);
    Route::get('/voucher/search', [App\Http\Controllers\adminController::class, 'searchVoucher']);
    Route::get('/voucher/kadaluwarsa/fresh', [App\Http\Controllers\adminController::class, 'voucherKadaluwarsaFresh']);
    Route::get('/voucher/kadaluwarsa/search', [App\Http\Controllers\adminController::class, 'voucherKadaluwarsaSearch']);
    Route::get('/voucher/kadaluwarsa', [App\Http\Controllers\adminController::class, 'voucherKadaluwarsa']);
    Route::get('/voucher/kadaluwarsa/{id}/hapus', [App\Http\Controllers\adminController::class, 'voucherKadaluwarsaHapus']);
    Route::get('/voucher/tambah', [App\Http\Controllers\adminController::class, 'tambahVoucher']);
    Route::get('/voucher/tambah-broker', [App\Http\Controllers\adminController::class, 'tambahVoucherBroker']);
    Route::post('/voucher/tambah', [App\Http\Controllers\adminController::class, 'tambahVoucherPost']);
    Route::get('/voucher/{id}/hapus', [App\Http\Controllers\adminController::class, 'hapusVoucher']);
    Route::get('/dashboard', [App\Http\Controllers\adminController::class, 'dashboard']);
    Route::get('/syarat', [App\Http\Controllers\adminController::class, 'syarat']);
    Route::get('/tentang', [App\Http\Controllers\adminController::class, 'tentang']);
    Route::get('/faq', [App\Http\Controllers\adminController::class, 'faq']);
    Route::get('/syarat/{id}/edit', [App\Http\Controllers\adminController::class, 'editSyarat']);
    Route::post('/syarat/{id}/edit', [App\Http\Controllers\adminController::class, 'syaratPost']);
    Route::get('/tentang/{id}/edit', [App\Http\Controllers\adminController::class, 'tentangEdit']);
    Route::post('/tentang/{id}/edit', [App\Http\Controllers\adminController::class, 'tentangPost']);
    Route::get('/faq/tambah', [App\Http\Controllers\adminController::class, 'tambahFaq']);
    Route::post('/faq/tambah', [App\Http\Controllers\adminController::class, 'tambahFaqPost']);
    Route::get('/faq/search', [App\Http\Controllers\adminController::class, 'searchFaq']);
    Route::get('/faq/{id}', [App\Http\Controllers\adminController::class, 'faqDetail']);
    Route::get('/faq/{id}/edit', [App\Http\Controllers\adminController::class, 'faqEdit']);
    Route::post('/faq/{id}/edit', [App\Http\Controllers\adminController::class, 'faqPost']);
    Route::get('/faq/{id}/hapus', [App\Http\Controllers\adminController::class, 'hapusFaq']);
    Route::get('/pengaturan', 'App\Http\Controllers\adminController@setting_kategori');
    Route::get('/pengaturan/{id}/ubah', 'App\Http\Controllers\adminController@ubah_gambar_kategori');
    Route::post('/pengaturan/pesan/{id}/edit', 'App\Http\Controllers\adminController@ubah_pesan_kategoriPost');
    Route::get('/pengaturan/pesan/{id}/ubah', 'App\Http\Controllers\adminController@ubah_pesan_kategori');
    Route::post('/pengaturan/{id}/ubah', 'App\Http\Controllers\adminController@ubah_gambar_kategoriPost');
});
