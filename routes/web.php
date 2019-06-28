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
    return view('welcome');
});

Route::get('/','Index\IndexController@index');
    Route::prefix('login')->group(function () {
        Route::any('login','Index\LoginController@login');
        Route::any('reg','Index\LoginController@reg');
        Route::any('add','Index\LoginController@add');
        Route::any('cate','Index\LoginController@cate');  
});

Route::prefix('goods')->group(function () {
    Route::any('goods','Index\GoodsController@goods');
    Route::any('proinfo','Index\GoodsController@proinfo');
    Route::any('check','Index\GoodsController@check');
    Route::any('addca','Index\GoodsController@addca');
    Route::any('getSubTotal','Index\GoodsController@getSubTotal');
    Route::any('del/{id}','Index\GoodsController@del');
    Route::any('dele/{id}','Index\GoodsController@dele');
    Route::any('pay','Index\GoodsController@pay');
    Route::any('order','Index\GoodsController@order'); 
    Route::any('orderadd','Index\GoodsController@orderadd'); 
}); 

// Route::any('pay','Index\AliPayController@pay'); 


Route::prefix('admin')->group(function () {
    Route::any('admin','Admin\AdminController@admin');
    Route::any('login','Admin\AdminController@login');
    Route::any('ass','Admin\AdminController@ass');
    Route::any('add','Admin\AdminController@add');
    Route::any('cate','Admin\AdminController@cate');
    Route::any('list','Admin\AdminController@list');
    Route::any('del/{id}','Admin\AdminController@del');
    Route::any('edit/{id}','Admin\AdminController@edit');
    Route::any('update/{id}','Admin\AdminController@update');
    Route::any('checkout','Admin\AdminController@checkout');
});
