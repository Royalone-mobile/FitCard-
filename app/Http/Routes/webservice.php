<?php

Route::any('/service/serviceFeaturedGym', 'WebServiceGymController@serviceFeaturedGym');
Route::any('/service/serviceLoadGym', 'WebServiceGymController@serviceLoadGym');
Route::any(
    '/service/serviceSearchGym/{city}/{keyword}/{activityIds}/{amenityIds}/{studioIds}/{locationIds}',
    'WebServiceGymController@serviceSearchGym'
);
Route::any('/service/serviceLoadReviewForGym/{gid}', 'WebServiceGymController@serviceLoadReviewForGym');
Route::any('/service/serviceBookGym/{no}/{gid}', 'WebServiceGymController@serviceBookGym');
Route::any('/service/serviceLastVisitGym/{no}/{gid}', 'WebServiceGymController@serviceLastVisitGym');
Route::any('/service/serviceDeleteGym/{id}/{uid}', 'WebServiceGymController@serviceDeleteGym');


Route::any(
    '/service/searchClass/{date}/{gid}/{city}/{category}/{keyword}/{uid}',
    'WebServiceClassController@searchClass'
);
Route::any('/service/serviceLoadReviewForClass/{cid}', 'WebServiceClassController@serviceLoadReviewForClass');
Route::any('/service/serviceLoadPlan', 'WebServiceClassController@serviceLoadPlan');
Route::any('/service/serviceBookClass/{no}/{cid}', 'WebServiceClassController@serviceBookClass');
Route::any('/service/serviceLoadBooks/{no}', 'WebServiceClassController@serviceLoadBooks');
Route::any('/service/serviceLastVisitClass/{no}/{cid}', 'WebServiceClassController@serviceLastVisitClass');
Route::any('/service/serviceDeleteClass/{id}/{uid}', 'WebServiceClassController@serviceDeleteClass');
Route::any('/service/serviceLoadOverBooks/{id}', 'WebServiceClassController@serviceLoadOverBooks');
Route::any('/service/serviceReviewClass', 'WebServiceClassController@serviceReviewClass');

Route::any('/service/serviceCouponCode/{couponCode}/{no}', 'WebServiceUserController@serviceCouponCode');
Route::any('/service/serviceLogin/{user}/{password}', 'WebServiceUserController@serviceLogin');
Route::any('/service/serviceRegister', 'WebServiceUserController@serviceRegister');
Route::any('/service/serviceChargeFund/{amount}', 'WebServiceUserController@serviceChargeFund');
Route::any('/service/serviceFundCheck/{token}', 'WebServiceUserController@serviceFundCheck');
Route::any('/service/serviceAfterPayment/{no}/{pid}/{token}', 'WebServiceUserController@serviceAfterPayment');
Route::any(
    '/service/serviceUpdateProfile/{no}/{email}/{phone}/{city}/{address}',
    'WebServiceUserController@updateProfile'
);
Route::any('/service/serviceUploadLogo', 'WebServiceUserController@serviceUploadLogo');
Route::any('/service/serviceContactUs', 'WebServiceUserController@serviceContactUs');
Route::any('/service/serviceGetCode', 'WebServiceUserController@serviceGetCode');
Route::any('/service/serviceUpdatePassword', 'WebServiceUserController@serviceUpdatePassword');
Route::any('/service/serviceChargeWithToken/{id}/{pid}', 'WebServiceUserController@serviceChargeWithToken');
Route::any('/service/serviceCleanCard/{id}', 'WebServiceUserController@serviceCleanCard');
Route::any('/service/serviceProfile/{id}', 'WebServiceUserController@serviceProfile');
