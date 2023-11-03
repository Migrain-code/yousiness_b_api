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

Route::get('city/list', [CityController::class, 'list']);
Route::post('city/search', [CityController::class, 'search']);

Route::prefix('business')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('check-phone', [AuthController::class, 'register']);
        Route::post('verify', [AuthController::class, 'verify']);
    });
    Route::get('/categories', [SetupController::class, 'categories']);
    Route::get('/packages', [BusinessPackageController::class, 'index']);

    Route::middleware('auth:business')->group(function () {

        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('/categories/add', [SetupController::class, 'addCategories']);
        Route::get('home', [BusinessHomeController::class, 'index']);
        Route::controller(SetupController::class)->prefix('setup')->group(function () {
            Route::get('/get', 'get');
            Route::post('/update', 'update');
            Route::post('/step/map', 'mapUpdate');
        });

        Route::controller(PaymentController::class)->prefix('payment')->group(function () {
            Route::post('/create-payment-intent','createPaymentIntent');
            Route::post('/process-payment', 'processPayment');
        });

        Route::controller(DetailSetupController::class)->prefix('detail-setup')->group(function () {
            Route::get('/step-1/get', 'index');
            Route::post('/step-1/update', 'step1');
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
    });

});

Route::prefix('personal')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [PersonalAuthController::class, 'login']);
    });

    Route::middleware('auth:personal')->group(function () {
        Route::get('user', [PersonalAuthController::class, 'user']);
        Route::post('logout', [PersonalAuthController::class, 'logout']);
    });
});
