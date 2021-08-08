<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'ShowBookController@welcome')->name('home');
Route::get('/welcome', 'ShowBookController@welcome')->name('welcome');
Route::get('/welcome/singlebook/{id}', 'ShowBookController@singlebook')->name('welcome.singlebook');
Route::post('/upload', 'UploadController@index')->name('upload');
Route::post('/contact', 'ContactController@addContact')->name('contact');

Route::prefix('user/')
    ->name('user.')
    ->group(function () {
        Route::get('/register', 'UserController@showRegisterForm')->name('register');
        Route::post('/register', 'UserController@registerPost')->name('registerPost');
        Route::get('/login', 'UserController@showLoginForm')->name('login');
        Route::post('/login', 'UserController@loginPost')->name('loginPost');
        Route::get('/logout', function () {
            Auth::logout();
            return redirect()->route('user.login');
        })->name('logout');
        Route::get('/forgetpass', 'UserController@viewForgetPassword')->name('forgetpass');
        Route::post('/forgetpass/post', 'UserController@postForgetPassword')->name('forgetpass.post');
        Route::post('/addcart', 'ShowBookController@addCart')->name("add.cart");
        Route::post('/deletecart', 'ShowBookController@deleteCart')->name("delete.cart");
        Route::post('/changecart', 'ShowBookController@changeCart')->name("change.cart");
        Route::post('/saveorder', 'ShowBookController@saveOrder')->name("save.order");

        Route::middleware('auth')->group(function () {
            Route::get('/profile', 'UserController@viewProfile')->name('profile');
            Route::post('/profile/edit', 'UserController@editProfile')->name('profile.edit');
            Route::get('/profile/changepass', 'UserController@viewChangePassword')->name('profile.view.changepass');
            Route::post('/profile/changepass/post', 'UserController@postChangePassword')->name('profile.post.changepass');
            Route::get('/order', 'UserController@viewListOrder')->name('order');
            Route::post('/order/cancel', 'UserController@cancelOrder')->name('order.cancel');
            Route::post('/alert/readed', 'UserController@changeAlert')->name('order.cancel');
        });
    });

Auth::routes();

Route::prefix('admin/')
    ->name('admin.')
    ->group(function () {
        Route::get('/login', 'AdminController@showLoginForm')->name('login');
        Route::post('/login', 'AdminController@loginPost')->name('loginPost');
        Route::get('/logout', function () {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        })->name('admin.logout');

        Route::middleware('admin')->group(function () {
            Route::get("/", "DataController@index")->name('home');
            Route::resource("book", "BookController");
            Route::resource("user", "ManageUserController");
            Route::resource("data", "DataController");
            Route::get("contact", "AdminContactController@index")->name('contact.index');
            Route::post("contact/readed", "AdminContactController@changeReaded");
            Route::post("contact/delete", "AdminContactController@deleteContact");
            Route::resource("order", "OrderAdminController");
            Route::post('order/changestatus', "OrderAdminController@changeStatusToBorrowing");
            Route::post('order/cancel', "OrderAdminController@cancelOrder");
            Route::post('order/edit', "OrderAdminController@editOrder");
            Route::post('order/delete', "OrderAdminController@changeAlert");
        });
    });

Route::prefix('ajax/')
    ->name('ajax.')
    ->group(function () {
        Route::get('/dashboardData', 'AjaxController@getDataAjax');
        Route::post('/search', 'AjaxController@searchDataByAjax');
        Route::post('/totalMoney', 'AjaxController@getTotalAjax');
        Route::post('/dashBoardOfMonth', 'AjaxController@dashBoardOfMonth');
        Route::post('/datefromto', 'AjaxController@dashBoardFromTo');
        Route::post('/getdata', 'AjaxController@getDaTa');
    });
