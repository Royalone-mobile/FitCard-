<?php

Route::any('/company', 'CompanyController@index');
Route::any('/company/login', 'CompanyController@login');
Route::any('/company/visitors', 'CompanyController@viewVisitors');
Route::any('/company/hours', 'CompanyController@viewHours');
Route::any('/company/reviews', 'CompanyController@viewReviews');
Route::any('/company/payments', 'CompanyController@viewPayments');
Route::any('/company/logout', 'CompanyController@actionLogout');
Route::any('/company/viewProfile', 'CompanyController@viewProfile');
Route::any('/company/actionEditProfile', 'CompanyController@actionEditProfile');


Route::any('/company/creategym', 'CompanyGymController@viewCreateGym');
Route::any('/company/actionCreateGym', 'CompanyGymController@actionCreateGym');
Route::any('/company/actionDeleteGym/{gid}', 'CompanyGymController@actionDeleteGym');
Route::any('/company/viewEditGym/{gid}', 'CompanyGymController@viewEditGym');
Route::any('/company/actionUpdateGym', 'CompanyGymController@actionEditGym');
Route::any('/company/ajaxMonthPayment', 'CompanyGymController@ajaxMonthPayment');


Route::any('/company/actionCreateClass', 'CompanyClassController@actionCreateClass');
Route::any('/company/actionDeleteClass/{cid}', 'CompanyClassController@actionDeleteClass');
Route::any('/company/viewEditClass/{cid}', 'CompanyClassController@viewEditClass');
Route::any('/company/actionUpdateClass', 'CompanyClassController@actionUpdateClass');
Route::any('/company/createclass', 'CompanyClassController@viewCreateClass');
Route::any('/company/classes', 'CompanyClassController@viewClasses');
