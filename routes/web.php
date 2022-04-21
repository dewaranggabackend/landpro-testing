<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\PropertiController;
use App\Http\Controllers\WEB\InformasiController;
use App\Http\Controllers\WEB\VoucherController;
use App\Http\Controllers\WEB\FAQController;
use App\Http\Controllers\WEB\SettingsController;
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

Route::get('/sorry', [adminController::class, 'sorry']);
Route::get('/request-otp', [adminController::class, 'requestOTP']);
Route::post('/request-otp', [adminController::class, 'requestOTPost']);
Route::post('/request-otp/{id}/verification', [adminController::class, 'requestOTPostVer']);
Route::get('/lupa-password', [adminController::class, 'lupaPassword']);
Route::post('/lupa-password', [adminController::class, 'lupaPasswordPost']);

Route::prefix('users')->group(function () {
    Route::post('{id}/forgot', [UserController::class, 'lupaPasswordSet']);
    Route::post('{id}/forgot/password', [UserController::class, 'lupaPasswordSetPassword']);
    Route::post('{id}/verification', [UserController::class, 'verificationOTP']);
});

Route::group(['middleware' => ['auth', 'CekRole:1']], function () {
    Route::get('/users', [UserController::class, 'users']);
    Route::prefix('users')->group(function () {
        Route::get('customer-service/del/{id}', [UserController::class, 'delCustServ']);
        Route::get('customer-service/create', [UserController::class, 'custServForm']);
        Route::post('customer-service/create', [UserController::class, 'custServPost']);
        Route::get('request/search', [UserController::class, 'requestSearch']);
        Route::get('request', [UserController::class, 'request']);
        Route::get('export', [UserController::class, 'userExcel']);
        Route::get('search', [UserController::class, 'usersSearch']);
        Route::get('banned', [UserController::class, 'viewban']);
        Route::get('banned/search', [UserController::class, 'bannedSearch']);
        Route::get('{id}/ban', [UserController::class, 'banned']);
        Route::get('{id}/unban', [UserController::class, 'unban']);
        Route::get('{id}/upgrade', [UserController::class, 'upgrade']);
        Route::get('{id}/downgrade', [UserController::class, 'downgrade']);
        Route::get('{id}/hapus', [UserController::class, 'hapus']);
        Route::get('{id}/request/setuju', [UserController::class, 'setujuRequest']);
        Route::get('{id}/request/tolak', [UserController::class, 'tolakRequest']);
    });

    Route::get('/properti', [PropertiController::class, 'properti']);
    Route::prefix('properti')->group(function () {
        Route::get('export', [PropertiController::class, 'propertiExcel']);
        Route::post('tambah', [PropertiController::class, 'tambahPropertiPost']);
        Route::get('expire', [PropertiController::class, 'propertiExpire']);
        Route::get('nonaktif', [PropertiController::class, 'nonaktif']);
        Route::get('search', [PropertiController::class, 'searchProperti']);
        Route::get('tambah', [PropertiController::class, 'tambahProperti']);
        Route::get('expire/fresh', [PropertiController::class, 'fresh']);
        Route::get('nonaktif/search', [PropertiController::class, 'searchPropertiTrashed']);
        Route::get('{id}/off',  [PropertiController::class, 'off']);
        Route::get('{id}/on', [PropertiController::class, 'aktif']);
        Route::get('{id}/hapus', [PropertiController::class, 'hapusProperti']);
        Route::get('{id}/detail', [PropertiController::class, 'detailProperti']);
        Route::get('{id}/stop',  [PropertiController::class, 'propertiStop']);
    });

    Route::get('/informasi', [InformasiController::class, 'informasi']);
    Route::prefix('informasi')->group(function () {
        Route::get('search', [InformasiController::class, 'searchInformasi']);
        Route::get('tambah', [InformasiController::class, 'tambahInformasi']);
        Route::post('tambah', [InformasiController::class, 'tambahInformasiPost']);
        Route::get('{id}/hapus', [InformasiController::class, 'hapusInformasi']);
        Route::get('{id}/edit', [InformasiController::class, 'editInformasi']);
        Route::post('{id}/edit', [InformasiController::class, 'editInformasiPost']);
        Route::get('{id}', [InformasiController::class, 'detailInformasi']);
    });

    Route::get('/voucher', [VoucherController::class, 'voucher']);
    Route::prefix('voucher')->group(function () {
        Route::get('search', [VoucherController::class, 'searchVoucher']);
        Route::get('kadaluwarsa/fresh', [VoucherController::class, 'voucherKadaluwarsaFresh']);
        Route::get('kadaluwarsa/search', [VoucherController::class, 'voucherKadaluwarsaSearch']);
        Route::get('kadaluwarsa', [VoucherController::class, 'voucherKadaluwarsa']);
        Route::get('tambah', [VoucherController::class, 'tambahVoucher']);
        Route::get('tambah-broker', [VoucherController::class, 'tambahVoucherBroker']);
        Route::post('tambah', [VoucherController::class, 'tambahVoucherPost']);
        Route::get('kadaluwarsa/{id}/hapus', [VoucherController::class, 'voucherKadaluwarsaHapus']);
        Route::get('{id}/hapus', [VoucherController::class, 'hapusVoucher']);
    });

    Route::get('/faq', [FAQController::class, 'faq']);
    Route::prefix('faq')->group(function () {
        Route::get('tambah', [FAQController::class, 'tambahFaq']);
        Route::post('tambah', [FAQController::class, 'tambahFaqPost']);
        Route::get('search', [FAQController::class, 'searchFaq']);
        Route::get('{id}/edit', [FAQController::class, 'faqEdit']);
        Route::post('{id}/edit', [FAQController::class, 'faqPost']);
        Route::get('{id}/hapus', [FAQController::class, 'hapusFaq']);
        Route::get('{id}', [FAQController::class, 'faqDetail']);
    });

    Route::get('/pengaturan', [SettingsController::class, 'setting_kategori']);
    Route::prefix('pengaturan')->group(function () {
        Route::post('pesan/{id}/edit', [SettingsController::class, 'ubah_pesan_kategoriPost']);
        Route::get('pesan/{id}/ubah', [SettingsController::class, 'ubah_pesan_kategori']);
        Route::get('{id}/ubah', [SettingsController::class, 'ubah_gambar_kategori']);
        Route::post('{id}/ubah', [SettingsController::class, 'ubah_gambar_kategoriPost']);
    });

    Route::get('/admin/kategori', [adminController::class, 'category']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/kategori', [adminController::class, 'category']);
    Route::get('/privacy', [adminController::class, 'privacy']);
    Route::get('/privacy/{id}/edit', [adminController::class, 'privacyEdit']);
    Route::post('/privacy/{id}/edit', [adminController::class, 'privacyPost']);
    Route::get('/dashboard', [adminController::class, 'dashboard']);
    Route::get('/syarat', [adminController::class, 'syarat']);
    Route::get('/tentang', [adminController::class, 'tentang']);
    Route::get('/syarat/{id}/edit', [adminController::class, 'editSyarat']);
    Route::post('/syarat/{id}/edit', [adminController::class, 'syaratPost']);
    Route::get('/tentang/{id}/edit', [adminController::class, 'tentangEdit']);
    Route::post('/tentang/{id}/edit', [adminController::class, 'tentangPost']);
});
