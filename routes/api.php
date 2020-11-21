<?php

//User Routes
Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

//Transaction Without Authentication
Route::group(['namespace' => 'Api'], function ($router) {
    Route::post('transaction', 'TransactionController@transaction');
    Route::post('transaction-queue', 'TransactionController@transactionQueue');
});

//Transaction With User Authentication
Route::group(['middleware' => 'apiJwt', 'namespace' => 'Api'], function ($router) {
    Route::post('transaction-with-authentication', 'TransactionController@transactionWithAuthentication');
    Route::post('transaction-queue-with-authentication', 'TransactionController@transactionQueueWithAuthentication');
});

//Get all users
Route::get('users', 'Api\UserController@index');

