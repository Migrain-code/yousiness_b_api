<?php

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

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\PaymentController;
use \App\Http\Controllers\Api\DetailSetupController;
use \App\Http\Controllers\Api\BusinessServiceController;
use \App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\SetupController;
use \App\Http\Controllers\Api\PackageSaleController;
use \App\Http\Controllers\Api\CustomerController;
use \App\Http\Controllers\Api\BusinessPackageController;
use \App\Http\Controllers\Api\PersonalAuthController;
use \App\Http\Controllers\Api\BusinessHomeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductSaleController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\StripeController;
use \App\Http\Controllers\Api\PasswordChangeController;
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

Route::post('send/mail', [\App\Http\Controllers\Api\Personel\HomeController::class, 'sendMail']);
Route::get('page/list', [CityController::class, 'setting']);
Route::post('page/detail', [CityController::class, 'pageDetail']);

Route::get('city/list', [CityController::class, 'list']);
Route::post('city/search', [CityController::class, 'search']);
Route::post('payment/success', [StripeController::class,'handleWebhook']);
Route::post('payment/fail', [StripeController::class,'handleWebhook']);
Route::prefix('business')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('check-phone', [AuthController::class, 'register']);
        Route::post('verify', [AuthController::class, 'verify']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
    Route::get('/categories', [SetupController::class, 'categories']);
    Route::get('/packages', [BusinessPackageController::class, 'index']);

    Route::middleware('auth:business')->group(function () {

        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::post('/categories/add', [SetupController::class, 'addCategories']);

        Route::post('home', [BusinessHomeController::class, 'index']);

        Route::controller(SetupController::class)->prefix('setup')->group(function () {
            Route::get('/get', 'get');
            Route::post('/update', 'update');
            Route::post('/step/map', 'mapUpdate');
        });

        Route::controller(\App\Http\Controllers\Api\StripeController::class)->prefix('stripe')->group(function () {
            Route::post('/create-payment-form','stripeForm');
            Route::post('/process-payment', 'processPayment');
        });

        Route::controller(DetailSetupController::class)->prefix('detail-setup')->group(function () {
            Route::get('/step-1/get', 'index');
            Route::post('/step-1/update', 'step1');
            Route::post('/step-1/upload/logo', 'uploadLogo');
            Route::post('/step-1/upload/gallery', 'uploadGallery');

        });

        Route::controller(BusinessServiceController::class)->prefix('business-service')->group(function () {
            Route::get('/', 'step2Get');
            Route::get('/list', 'serviceList');
            Route::post('/get', 'step2GetService');
            Route::post('/add', 'step2AddService');
            Route::post('/update', 'step2UpdateService');
            Route::post('/delete', 'step2DeleteService');
            Route::post('/gender/get', 'gender');
            Route::post('/category/get', 'category');
            /*Route::post('/update/logo', 'updateLogo');*/
        });

        Route::controller(PersonalController::class)->prefix('personal')->group(function () {
            Route::get('/', 'step3Get');
            Route::post('/get', 'step3GetPersonal');
            Route::get('/add/get', 'step3AddGetPersonal');
            Route::post('/add', 'step3AddPersonal');
            Route::post('/update', 'step3UpdatePersonal');
            Route::post('/delete', 'step3DeletePersonal');
        });

        Route::controller(PackageSaleController::class)->prefix('package-sale')->group(function () {
            Route::get('/', 'index');
            Route::get('/create-packet', 'createPacket');
            Route::post('/payments', 'payments');
            Route::post('/usages', 'usages');
            Route::post('/add-packet', 'addPacket');
            Route::post('/add-payment', 'addPayment');
            Route::post('/add-usage', 'addUsage');
            Route::post('/delete', 'destroy');
        });

        Route::controller(CustomerController::class)->prefix('customer')->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'create');
            Route::post('/edit', 'edit');
            Route::post('/update', 'update');
            Route::post('/delete', 'destroy');
        });

        Route::controller(ProductController::class)->prefix('product')->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'create');
            Route::post('/update', 'update');
            Route::post('/delete', 'destroy');
        });

        Route::controller(ProductSaleController::class)->prefix('product-sale')->group(function () {
            Route::get('/', 'index');
            Route::get('/get-info', 'createProduct');
            Route::post('/create', 'store');
            Route::post('/update', 'update');
            Route::post('/delete', 'destroy');
        });

        Route::controller(AppointmentController::class)->prefix('appointment')->group(function () {
            Route::post('/', 'index');
            Route::post('/detail', 'detail');
            Route::post('/cancel', 'cancel');
        });

        Route::controller(GalleryController::class)->prefix('gallery')->group(function () {
            Route::get('/', 'index');
            Route::post('/upload', 'uploadLogo');
        });

        Route::controller(SupportController::class)->prefix('support')->group(function () {
            Route::get('/', 'index');
            Route::post('/create', 'store');
            Route::post('/detail', 'detail');
            Route::post('/delete', 'destroy');
        });

        Route::controller(CommentController::class)->prefix('comment')->group(function () {
            Route::get('/', 'index');
            Route::post('/detail', 'detail');
        });

        Route::controller(PasswordChangeController::class)->prefix('password')->group(function () {
            Route::post('/update', 'update');
        });

    });

});

Route::prefix('personal')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [PersonalAuthController::class, 'login']);
    });

    Route::middleware('auth:personal')->group(function () {
        Route::get('user', [PersonalAuthController::class, 'user']);
        Route::post('logout', [PersonalAuthController::class, 'logout']);

        Route::post('home', [\App\Http\Controllers\Api\Personel\HomeController::class, 'index']);

        Route::controller(\App\Http\Controllers\Api\Personel\AppointmentController::class)->prefix('appointment')->group(function () {
            Route::post('/', 'index');
            Route::post('/detail', 'detail');
            Route::post('/cancel', 'cancel');
        });

        Route::controller(\App\Http\Controllers\Api\Personel\PackageSaleController::class)->prefix('package-sale')->group(function () {
            Route::get('/', 'index');
            Route::get('/create-packet', 'createPacket');
            Route::post('/payments', 'payments');
            Route::post('/usages', 'usages');
            Route::post('/add-packet', 'addPacket');
            Route::post('/add-payment', 'addPayment');
            Route::post('/add-usage', 'addUsage');
            Route::post('/delete', 'destroy');
        });

        Route::controller(\App\Http\Controllers\Api\Personel\ProductSaleController::class)->prefix('product-sale')->group(function () {
            Route::get('/', 'index');
            Route::get('/get-info', 'createProduct');
            Route::post('/create', 'store');
            Route::post('/update', 'update');
            Route::post('/delete', 'destroy');
        });

    });


});
