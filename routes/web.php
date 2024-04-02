<?php

use App\Http\Controllers\Admin\SongController;
use App\Livewire\ReverbTest;
use Illuminate\Support\Facades\Route;


Route::view('/', 'layout.admin')->middleware('auth:admin');
Route::view('/test', 'test');
Route::get('/linkstorage', function () {
    $targetFolder = base_path() . '/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    //// Admin Routes ///

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.',], function () {
        Route::view('login', 'admin.auth.login')->name('login');
        Route::post('login', 'AuthController@login')->name('adminlogin');
        Route::get('logout', 'AuthController@logout')->name('logout')->middleware('auth:admin');

        Route::group(['middleware' => 'auth:admin'], function () {
            Route::view('dashboard', 'layout.admin')->name('dashboard');
            Route::resource('song', SongController::class);
        });
    });
});
