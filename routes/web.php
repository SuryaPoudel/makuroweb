<?php

Route::get('/home', function () {
    return view('index');
});
Route::get('/', function () {
    return view('index');
});
Route::get('/contact', function () {
    return view('layouts.frontend-pages.contact');
});
Route::get('/page/{id}', 'FrontController@getpage_dynamically');
Auth::routes();
Route::group(['middleware'=>'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );
    

});

