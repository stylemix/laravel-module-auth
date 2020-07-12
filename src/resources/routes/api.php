<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes...
Route::get('login', 'LoginController@showLoginForm')->name('login.form');
Route::post('login', 'LoginController@login')->name('login');
Route::post('refresh', 'LoginController@refresh')->name('refresh');
Route::post('logout', 'LoginController@logout')->name('logout');
// Password Reset Routes...
Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
