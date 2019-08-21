<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/meal', ['uses' => 'ApiController@getAllMeal']);
    Route::get('/meal/{id}/{userid}', ['uses' => 'ApiController@getMealById']);
    Route::get('/meal-category/{name}', ['uses' => 'ApiController@getMealByCategory']);
    Route::post('/cart', ['uses' => 'ApiController@createCart']);
    Route::get('/cart/{user}', ['uses' => 'ApiController@getCart']);
    Route::post('/purchase', ['uses' => 'ApiController@createOrder']);
    Route::get('/purchase/{user}', ['uses' => 'ApiController@getOrder']);
    Route::get('/purchase-status/{purchaseID}', ['uses' => 'ApiController@getOrderStatus']);
    Route::get('/checkout/{purchaseID}', ['uses' => 'ApiController@checkOut']);
    Route::post('/delete', ['uses' => 'ApiController@deleteFromCart']);
    Route::post('/delete-all', ['uses' => 'ApiController@deleteAllFromCart']);
    Route::get('/fav/{userID}', ['uses' => 'ApiController@getFavourite']);
    Route::post('/fav', ['uses' => 'ApiController@addFavourite']);
    Route::post('/fav-rm', ['uses' => 'ApiController@removeFavourite']);
    Route::post('/login', ['uses' => 'ApiController@login']);
    Route::post('/register', ['uses' => 'ApiController@register']);

    Route::get('/', 'PagesController@getIndex');
    Route::get('/admin/purchase', ['uses' => 'PagesController@getOrder']);
    Route::get('/admin/purchase/{id}', ['uses' => 'PagesController@updateStatus']);
    Route::get('/users', 'PagesController@getUser');
});
