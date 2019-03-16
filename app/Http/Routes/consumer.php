<?php

Route::any('/', ['as' => 'consumer.home', 'uses' => 'ConsumerPageController@index']);
Route::any('/consumer', ['as' => 'consumer.home', 'uses' => 'ConsumerPageController@index']);

Route::any('/consumer/gyms', 'ConsumerPageController@viewListGym');
Route::any('/consumer/contact', 'ConsumerPageController@viewContacts');
Route::any('/consumer/invite', 'ConsumerPageController@viewInvites');
Route::any('/consumer/classlist', 'ConsumerPageController@viewListClass');
Route::any('/consumer/partner', 'ConsumerPageController@viewPartner');
Route::any('/consumer/about', 'ConsumerPageController@viewAbout');

Route::any('/consumer/detailgym', 'ConsumerBookController@viewDetailGym');
Route::any('/consumer/detailgym/{gid}', 'ConsumerBookController@viewDetailGym');
Route::any('/consumer/detailclass/{cid}', 'ConsumerBookController@viewDetailClass');
Route::any('/consumer/actionBookClass/{cid}', 'ConsumerBookController@actionBookClass');
Route::any('/consumer/actionBookGym/{gid}', 'ConsumerBookController@actionBookGym');
Route::any('/consumer/actionCancelBook/{bookid}', 'ConsumerBookController@actionCancelBook');
Route::any('/consumer/books', 'ConsumerBookController@viewBooks');
Route::any('/consumer/actionCreateReview', 'ConsumerBookController@actionCreateReview');
Route::any('/consumer/ajaxSearchGym', 'ConsumerBookController@ajaxSearchGym');
Route::any('/consumer/ajaxSearchClass', 'ConsumerBookController@ajaxSearchClass');
Route::any('/consumer/ajaxClassCount/{bDate}', 'ConsumerController@ajaxClassCount');
Route::any('/consumer/ajaxUploadConsumerLogo', 'ConsumerController@ajaxUploadConsumerLogo');
Route::any('/consumer/actionInviteFriend', 'ConsumerController@actionInviteFriend');

Route::any('/consumer/actionLanguage/{id}', 'ConsumerUserController@actionChangeLanguage');
Route::any('/consumer/actionPostFacebook', 'ConsumerUserController@actionPostFacebook');
Route::any('/consumer/actionUpdateProfile', 'ConsumerUserController@actionUpdateProfile');
Route::any('/consumer/profile', 'ConsumerUserController@viewProfile');

Route::any('/consumber/actionMembership/{pid}', 'ConsumerPaymentController@actionMemership');
Route::any('/consumer/actionAddCredit/{pid}/{token}', 'ConsumerPaymentController@actionAddCredit');
Route::any('/consumer/actionCouponCode', 'ConsumerPaymentController@actionCouponCode');
Route::any('/consumer/viewChargeFunds', 'ConsumerPaymentController@viewChargeFunds');
Route::any('/consumer/actionChargeWithToken/{pid}', 'ConsumerPaymentController@actionChargeWithToken');


Route::group(['prefix' => 'consumer'], function () {

    // Login and registration
    Route::group(['prefix' => 'auth'], function () {

        Route::get('login', [
            'as'   => 'consumer.auth.login',
            'uses' => 'Consumer\Authentication@login'
        ]);

        Route::get('forgot', [
            'as'   => 'consumer.auth.forgot',
            'uses' => 'Consumer\Authentication@forgotPassword'
        ]);

        Route::get('reset', [
            'as'   => 'auth.passwords.reset',
            'uses' => 'Consumer\Authentication@resetPassword'
        ]);

        Route::get('login/facebook', [
            'as'   => 'consumer.auth.login.facebook',
            'uses' => 'Consumer\Authentication@redirectToFacebookLogin'
        ]);

        Route::get('login/facebook_callback', [
            'as'   => 'consumer.auth.login.facebook_callback',
            'uses' => 'Consumer\Authentication@facebookLoginCallback'
        ]);

        Route::get('register', [
            'as'   => 'consumer.auth.register',
            'uses' => 'Consumer\Authentication@register'
        ]);
    });

    // Authenticated routes
    Route::group(['middleware' => 'auth'], function () {

        Route::get('payment/credit-card/{plan}', [
            'as'   => 'consumer.payment.credit-card',
            'uses' => 'Consumer\Payment@creditCard'
        ]);

        Route::get('payment/plans', 'Consumer\Payment@plans');
    });
});
