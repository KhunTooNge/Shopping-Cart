<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;
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

// login /register
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth#dashboard');

    //admin
    Route::middleware('admin_auth')->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            // Admin
            Route::get('password', [AuthController::class, 'editPassword'])->name('admin#editPassword');
            Route::get('account', [AuthController::class, 'accountPage'])->name('admin#account');
            Route::get('editProfile', [AuthController::class, 'editPage'])->name('admin#editProfile');
            Route::post('password/update', [AuthController::class, 'updatePassword'])->name('admin#updatePassword');
            Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('admin#updateProfile');
            Route::get('adminlist', [AuthController::class, 'adminlist'])->name('admin#list');
            Route::get('user/delete/{id}', [AuthController::class, 'userDelete'])->name('admin#userDelete');
            Route::get('role/{id}', [AuthController::class, 'role'])->name('admin#role');
            Route::post('role/{id}', [AuthController::class, 'roleChange'])->name('admin#roleChange');
        });

        Route::group(['prefix' => 'admin/contact'], function () {
            Route::get('page', [ContactController::class, 'adminContactPage'])->name('admin#contact');
        });

        Route::prefix('category')->group(function () {
            //category
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('addCategory', [CategoryController::class, 'add'])->name('category#add');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });

        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'index'])->name('product#list');
            //create
            Route::get('add', [ProductController::class, 'add'])->name('product#add');
            Route::post('add', [ProductController::class, 'create'])->name('product#create');
            //delete
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
            //detail
            Route::get('detail/{id}', [ProductController::class, 'detail'])->name('product#detail');
            //update
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product#edit');
            Route::post('edit', [ProductController::class, 'update'])->name('product#update');
        });

        Route::prefix('order')->group(function () {
            // list
            Route::get('listPage', [OrderController::class, 'index'])->name('admin#orderList');
            Route::get('sortStatus', [OrderController::class, 'sortStatus'])->name('admin#sortStatus');
            Route::get('detail/{orderCode}', [OrderController::class, 'detail'])->name('admin#detail');
            Route::get('ajax/changeStatus', [OrderController::class, 'changeStatus'])->name('admin#changeStatus');
        });
        Route::prefix('customer')->group(function () {
            Route::get('list', [UserController::class, 'customerList'])->name('customer#list');
            Route::get('delete/{id}', [UserController::class, 'customerDelete'])->name('customer#delete');
            Route::get('roleChange', [AjaxController::class, 'roleChange'])->name('user#roleChange');
        });
    });

    //user
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('home', [UserController::class, 'home'])->name('user#home');
        Route::get('filter/{id}', [UserController::class, 'filterCategory'])->name('filter#category');
        Route::get('price', [UserController::class, 'searchByPrice'])->name('searchByPrice');
        Route::get('detail', [UserController::class, 'detail'])->name('user#product#detail');
        Route::get('addToCart', [UserController::class, 'addToCart'])->name('user#addToCart');
        Route::get('history', [UserController::class, 'history'])->name('user#history');

        // ajax
        Route::get('ajax/pizza/list', [AjaxController::class, 'ajaxCall'])->name('user#ajax');
        Route::get('ajax/cart', [AjaxController::class, 'createCart'])->name('user#createCart');
        Route::get('ajax/clearAllCart', [AjaxController::class, 'clearAllCart'])->name('user#clearAllCart');
        Route::get('ajax/clearCartById', [AjaxController::class, 'clearCartById'])->name('user#clearCartById');
        Route::get('ajax/addOneCart', [AjaxController::class, 'addOneCart'])->name('user#addOneCart');
        Route::get('ajax/viewCount', [AjaxController::class, 'viewCount'])->name('user#viewCount');
    });

    //password
    Route::prefix('change')->group(function () {
        Route::get('password', [UserController::class, 'passwordChange'])->name('user#passchange');
        Route::post('password', [UserController::class, 'passwordUpdate'])->name('user#passUpdate');
    });

    //account
    Route::prefix('account')->group(function () {
        Route::get('edit', [UserController::class, 'editProfile'])->name('account#edit');
        Route::post('update', [UserController::class, 'updateUser'])->name('account#update');
    });

    // order and orderlist user view
    Route::prefix('order')->group(function () {
        Route::get('list', [OrderController::class, 'order'])->name('user#order');
    });

    // contact
    Route::prefix('contact')->group(function () {
        Route::get('page', [ContactController::class, 'contact'])->name('user#contact');
        Route::post('page', [ContactController::class, 'create'])->name('user#contact#create');
    });
});
