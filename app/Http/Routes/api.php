<?php
/**
 * The API routes
 */

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () {

    Route::post('upload-image', [
        'as'   => 'api.upload-image',
        'uses' => 'Api\v1\ImageController@uploadImage'
    ]);

    Route::group(['prefix' => 'payment'], function () {

        // Create new charge request for payment
        Route::get('create_charge/{plan}', [
            'as'   => 'api.v1.payment.create_charge',
            'uses' => 'Api\v1\PaymentController@createCharge'
        ]);

        Route::get('pay_with_token/{plan}', [
            'as'   => 'api.v1.payment.pay_with_token',
            'uses' => 'Api\v1\PaymentController@payWithToken'
        ]);

        // Check if payment was successful
        Route::post('check_successful', [
            'as'   => 'api.v1.payment.payment_successful',
            'uses' => 'Api\v1\PaymentController@paymentSuccessful'
        ]);
    });
});
