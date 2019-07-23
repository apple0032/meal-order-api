<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/meal', ['uses' => 'ApiController@getAllMeal']);
    Route::get('/meal/{id}', ['uses' => 'ApiController@getMealById']);
    Route::get('/meal/category/{name}', ['uses' => 'ApiController@getMealByCategory']);
    Route::post('/cart', ['uses' => 'ApiController@createCart']);
    Route::get('/cart/{user}', ['uses' => 'ApiController@getCart']);
    Route::post('/purchase', ['uses' => 'ApiController@createOrder']);
    Route::get('/purchase/{user}', ['uses' => 'ApiController@getOrder']);
    Route::get('/waiting/{user}', ['uses' => 'ApiController@getWaiting']);
    Route::put('/checkout/{purchaseID}', ['uses' => 'ApiController@checkOut']);
});
