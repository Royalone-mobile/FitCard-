<?php

Route::any('/business', 'BusinessController@loginBusiness');
Route::any('/business/login', 'BusinessController@actionLogin');
Route::any('/business/dashboard', 'BusinessController@viewDashboard');
Route::any('/business/users', 'BusinessController@viewUsers');
Route::any('/business/profile/{id}', 'BusinessController@viewProfile');
Route::any('/business/actionUpdateGraph', 'BusinessController@actionUpdateGraph');
Route::any('/business/logout', 'BusinessController@actionLogout');
