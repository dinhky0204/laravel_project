<?php

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

Route::get('/', function () {
    return view('home');
})->name('home');
Auth::routes();

//Route::get('/register', 'Auth\RegisterController@register')->name('register');
Route::get('/home', 'HomeController@index');
Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/confirm/resetpass/{token}','Auth\ResetPasswordController@resetPasswordConfirm')->name('confirmresetpass');
Route::get('/passwordreset', 'Auth\ResetPasswordController@reset')->name('resetpassword');
Route::post('/passwordreset/sendmail', 'Auth\ResetPasswordController@sendmailToReset')->name('sendmailToReset');
//Route::get('/create', 'RegisterController@create')->name('createaccount');