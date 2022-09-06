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


Route::group(['middleware' => 'auth', 'prevent-back-history'], function () {
    //trigger daily notifications
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

    //Role Routes
    Route::get('/role/view', [App\Http\Controllers\RoleController::class, 'view'])->middleware('can:View Role');
    Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'create'])->middleware('can:Add Role');
    Route::post('/role/store', [App\Http\Controllers\RoleController::class, 'store'])->middleware('can:Add Role');
    Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('can:Edit Role');
    Route::post('/role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('can:Edit Role');
    Route::get('/role/destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:Delete Role');
    Route::post('/role/role_check', [App\Http\Controllers\RoleController::class, 'role_check']);
    
    //User Routes
    Route::get('/user/view', [App\Http\Controllers\UserController::class, 'view'])->middleware('can:View User');
    Route::get('/user/add', [App\Http\Controllers\UserController::class, 'create'])->middleware('can:Add User');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:Add User');
    Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->middleware('can:Edit User');
    Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:Edit User');
    Route::get('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:Delete User');

    //Vehicle Routes
    Route::get('/vehicle/view', [App\Http\Controllers\VehicleController::class, 'view'])->middleware('can:View Vehicle');
    Route::get('/vehicle/add', [App\Http\Controllers\VehicleController::class, 'create'])->middleware('can:Add Vehicle');
    Route::post('/vehicle/store', [App\Http\Controllers\VehicleController::class, 'store'])->middleware('can:Add Vehicle');
    Route::get('/vehicle/edit/{id}', [App\Http\Controllers\VehicleController::class, 'edit'])->middleware('can:Edit Vehicle');
    Route::post('/vehicle/update/{id}', [App\Http\Controllers\VehicleController::class, 'update'])->middleware('can:Edit Vehicle');
    Route::get('/vehicle/destroy/{id}', [App\Http\Controllers\VehicleController::class, 'destroy'])->middleware('can:Delete Vehicle');

    //Routeway Routes
    Route::get('/route/view', [App\Http\Controllers\RouteController::class, 'view'])->middleware('can:View Route');
    Route::get('/route/add', [App\Http\Controllers\RouteController::class, 'create'])->middleware('can:Add Route');
    Route::post('/route/store', [App\Http\Controllers\RouteController::class, 'store'])->middleware('can:Add Route');
    Route::get('/route/edit/{id}', [App\Http\Controllers\RouteController::class, 'edit'])->middleware('can:Edit Route');
    Route::post('/route/update/{id}', [App\Http\Controllers\RouteController::class, 'update'])->middleware('can:Edit Route');
    Route::get('/route/destroy/{id}', [App\Http\Controllers\RouteController::class, 'destroy'])->middleware('can:Delete Route');
    Route::post('/city/store', [App\Http\Controllers\RouteController::class, 'city_store'])->middleware('can:Add City');

    //Subscription Routes
    Route::get('/subscription/view', [App\Http\Controllers\SubscriptionController::class, 'view'])->middleware('can:View Subscription');
    Route::get('/subscription/add', [App\Http\Controllers\SubscriptionController::class, 'create'])->middleware('can:Add Subscription');
    Route::post('/subscription/store', [App\Http\Controllers\SubscriptionController::class, 'store'])->middleware('can:Add Subscription');
    Route::get('/subscription/edit/{id}', [App\Http\Controllers\SubscriptionController::class, 'edit'])->middleware('can:Edit Subscription');
    Route::post('/subscription/update/{id}', [App\Http\Controllers\SubscriptionController::class, 'update'])->middleware('can:Edit Subscription');
    Route::get('/subscription/destroy/{id}', [App\Http\Controllers\SubscriptionController::class, 'destroy'])->middleware('can:Delete Subscription');

    //User Subscription Routes
    Route::get('/user-subscription/view', [App\Http\Controllers\UserSubscriptionController::class, 'view'])->middleware('can:View User Subscription');
    Route::get('/user-subscription/add', [App\Http\Controllers\UserSubscriptionController::class, 'create'])->middleware('can:Add User Subscription');
    Route::post('/user-subscription/store', [App\Http\Controllers\UserSubscriptionController::class, 'store'])->middleware('can:Add User Subscription');
    Route::get('/user-subscription/edit/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'edit'])->middleware('can:Edit User Subscription');
    Route::post('/user-subscription/update/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'update'])->middleware('can:Edit User Subscription');
    Route::get('/user-subscription/destroy/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'destroy'])->middleware('can:Delete User Subscription');
    Route::get('/user-subscription/mail/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'renew_mail'])->middleware('can:Renewal Mail User Subscription');
    Route::get('/user-subscription/acknowledge/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'acknowledge'])->middleware('can:Acknowledge User Subscription');

    //Trip Routes
    Route::get('/trip/view', [App\Http\Controllers\TripController::class, 'view'])->middleware('can:View Trip');
    Route::get('/trip/add', [App\Http\Controllers\TripController::class, 'create'])->middleware('can:Add Trip');
    Route::post('/trip/store', [App\Http\Controllers\TripController::class, 'store'])->middleware('can:Add Trip');
    Route::get('/trip/edit/{id}', [App\Http\Controllers\TripController::class, 'edit'])->middleware('can:Edit Trip');
    Route::post('/trip/update/{id}', [App\Http\Controllers\TripController::class, 'update'])->middleware('can:Edit Trip');
    Route::get('/trip/destroy/{id}', [App\Http\Controllers\TripController::class, 'destroy'])->middleware('can:Delete Trip');
    Route::post('/trip/get/rate', [App\Http\Controllers\TripController::class, 'get_rate'])->name('getRate')->middleware('can:Add Trip');
    Route::get('/trip/acknowledge/{id}', [App\Http\Controllers\TripController::class, 'acknowledge'])->middleware('can:Acknowledge Trip');

    //Bill Routes
    Route::get('/bill/view', [App\Http\Controllers\BillController::class, 'view'])->middleware('can:View Bill');
    Route::post('/bill/generate/monthly/statement', [App\Http\Controllers\BillController::class, 'monthly_generate'])->middleware('can:Generate Monthly Bill');
    Route::post('/bill/generate/monthly/range/statement', [App\Http\Controllers\BillController::class, 'monthly_range_generate'])->middleware('can:Generate Monthly Range Bill');

    //Order Booking
    Route::get('/order-book/view', [App\Http\Controllers\OrderBookingController::class, 'view'])->middleware('can:Book Order');
    Route::get('/order-book/add/{id}', [App\Http\Controllers\OrderBookingController::class, 'add'])->middleware('can:Book Order');
    Route::post('/order-book/subscription/details', [App\Http\Controllers\OrderBookingController::class, 'subscription_details'])->name('getSubscriptionDetails')->middleware('can:Book Order');
    Route::post('/order-book/normal/details', [App\Http\Controllers\OrderBookingController::class, 'normal_details'])->name('getNormalDetails')->middleware('can:Book Order');

    
});