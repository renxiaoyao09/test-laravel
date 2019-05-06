<?php

use Illuminate\Http\Request;

Route::group([], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'RegisterController@register');
});

Route::prefix('mine')->group(function($router){
    Route::post('me', 'Mine\Settings\SettingController@me');
});

