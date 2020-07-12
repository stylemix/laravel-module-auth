<?php

use Illuminate\Support\Facades\Route;

Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
