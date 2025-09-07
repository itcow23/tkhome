<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategorySubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DialogflowController;
use App\Http\Controllers\FrontedController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontedController::class,'index'])->name('client.home');
Route::get('/product', [FrontedController::class,'product'])->name('client.product');
Route::get('/product/{slug}', [FrontedController::class,'productCategory'])->name('client.productCategory');
Route::get('/product_details/{slug}', [FrontedController::class,'productDetail'])->name('client.product_details');

//filter products

Route::post('/filter_product', [FrontedController::class,'filterProducts'])->name('client.filter_products');
//login
Route::get('/login', [UserController::class,'login'])->name('client.login');
Route::post('/login', [UserController::class,'processLoginClient'])->name('client.processLogin');

//logout
Route::get('/logout', [UserController::class,'logout'])->name('client.logout');

//register
Route::get('/register', [UserController::class,'register'])->name('client.register');
Route::post('/register', [UserController::class,'processRegister'])->name('client.processRegister');

//foget password
Route::get('/forget-password', [UserController::class,'forgetPassword'])->name('client.forgetPassword');
Route::post('/forget-password', [UserController::class,'processForgetPassword'])->name('client.processForgetPassword');

//re password
Route::get('/re-password', [UserController::class,'rePassword'])->name('client.rePassword');
Route::post('/re-password', [UserController::class,'processRePassword'])->name('client.processRePassword');

//change password
Route::get('/change-password', [UserController::class,'changePassword'])->name('client.changePassword');
Route::post('/change-password', [UserController::class,'processChangePassword'])->name('client.processChangePassword');

//Add to cart
Route::get('/add_to_cart/{slug}', [FrontedController::class,'addToCart'])->name('client.add_to_cart');
//show cart
Route::get('/cart', [FrontedController::class,'showCart'])->name('client.cart');
//update cart
Route::get('/update_cart', [FrontedController::class,'updateCart'])->name('client.updateCart');
//destroy cart
Route::post('/destroy_cart', [FrontedController::class,'destroyCart'])->name('client.destroyCart');

//show checkout
Route::get('/checkout', [FrontedController::class,'showCheckout'])->middleware('client')->name('client.checkout');
Route::post('/load_district', [FrontedController::class,'getDistrict'])->middleware('client')->name('client.district');
Route::post('/load_ward', [FrontedController::class,'getWard'])->middleware('client')->name('client.ward');

//process checkout
Route::post('/process_checkout', [FrontedController::class,'processCheckout'])->name('client.process_checkout');

//checkout success
Route::get('/checkout_success', function () {
    return view('client.checkout_success');
})->middleware('client')->name('client.checkout_success');



//oder
Route::get('/order', [FrontedController::class,'order'])->middleware('client')->name('client.order');

Route::post('/filter_order', [FrontedController::class,'filterOrders'])->name('client.filter_orders');

//cancel order
Route::get('/cancel_order/{id}', [FrontedController::class,'cancelOrder'])->name('client.cancel_order');

Route::get('/contact', function () {
    return view('client.contact');
})->middleware('client')->name('client.contact');
Route::get('/test', function () {
    return view('client.test');
})->name('client.test');



Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::prefix('admin')->middleware('admin.login')->name('admin.')->group( function () {

    // Route::get('/',function(){
    //     return view('admin.home');
    // })->name( 'home');
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/sales-range', [DashboardController::class, 'getSalesRange'])->name('sales-range');
        Route::get('/sales-by-category', [DashboardController::class, 'getSalesByCategory'])->name('sales-by-category');
        Route::get('/top-products', [DashboardController::class, 'getTopProducts'])->name('top-products');
        
    Route::prefix('product')->name('product.')->group( function () {
        Route::get('/',[ProductController::class,'index'])->name('home');
        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/store',[ProductController::class,'store'])->name('store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('edit');
        Route::post('/edit',[ProductController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[ProductController::class,'delete'])->name('delete');
    });

    Route::prefix('user')->name('user.')->group( function () {
        Route::get('/',[UserController::class,'index'])->name('home');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::post('/edit',[UserController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[UserController::class,'delete'])->name('delete');
    });

    Route::prefix('order')->name('order.')->group( function () {
        Route::get('/',[OrderController::class,'index'])->name('home');; 
        Route::get('/accept/{id}',[OrderController::class,'accept'])->name('accept');
        Route::get('/cancel/{id}',[OrderController::class,'cancel'])->name('cancel');
        Route::get('/ship_success/{id}',[OrderController::class,'ship_success'])->name('ship_success');
        Route::get('/filter_order', [OrderController::class,'filterOrders'])->name('filter_orders');
    });
   
    Route::prefix( 'category')->name('category.')->group( function () {
        Route::get('/',[CategoryController::class,'index'])->name('home');
        Route::get('/create',[CategoryController::class,'create'])->name('create');
        Route::post('/store',[CategoryController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
        Route::post('/edit',[CategoryController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[CategoryController::class,'delete'])->name('delete'); 
    });
    Route::prefix( 'category_sub')->name('category_sub.')->group( function () {
        Route::get('/',[CategorySubController::class,'index'])->name('home');
        Route::get('/create',[CategorySubController::class,'create'])->name('create');
        Route::post('/store',[CategorySubController::class,'store'])->name('store');
        Route::get('/edit/{id}',[CategorySubController::class,'edit'])->name('edit');
        Route::post('/edit',[CategorySubController::class,'update'])->name('update');
        Route::delete('/delete/{id}',[CategorySubController::class,'delete'])->name('delete'); 
    });

});

Route::prefix('admin')->name('admin.')->group( function () {
    //login admin
    Route::get('/login', [UserController::class,'loginAdmin'])->name('login');
    Route::post('/login', [UserController::class,'processLoginAdmin'])->name( 'processLoginAdmin');
    //logout admin
    Route::get('/logout', [UserController::class,'logoutAdmin'])->name( 'logoutAdmin');
});