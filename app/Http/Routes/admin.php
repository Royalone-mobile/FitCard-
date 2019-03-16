<?php

Route::any('/admin', 'AdminMenuController@index');

Route::any('/admin/login', 'AdminController@postLogin');
Route::any('/admin/logout', 'AdminController@logout');

Route::any('/admin/gyms', 'AdminGymController@viewGyms');
Route::any('/admin/creategym', 'AdminGymController@viewCreateGym');
Route::any('/admin/editgym', 'AdminGymController@viewEditGym');
Route::any('/admin/gymcategory', 'AdminGymController@viewGymCategoryManage');
Route::any('/admin/actionCreateGymCategory', 'AdminGymController@actionCreateGymCategory');
Route::any('/admin/actionDeleteGym/{gid}', 'AdminGymController@actionDeleteGym');
Route::any('/admin/actionDeleteGymCategory/{cid}', 'AdminGymController@actionDeleteGymCategory');
Route::any('/admin/actionCreateGym', 'AdminGymController@actionCreateGym');
Route::any('/admin/actionUpdateGym', 'AdminGymController@actionEditGym');
Route::any('/admin/viewEditGym/{gid}', 'AdminGymController@viewEditGym');
Route::any('/admin/gymCode', 'AdminGymController@viewGymCode');
Route::any('/admin/ajaxAddGymCode', 'AdminGymController@ajaxAddGymCode');
Route::any('/admin/actionDeleteCode/{id}', 'AdminGymController@actionDeleteCode');
Route::any('/admin/business', 'AdminMenuController@viewBusiness');
Route::any('/admin/actionCreateBusiness', 'AdminMenuController@actionCreateBusiness');
Route::any('/admin/actionDeleteBusiness/{id}', 'AdminMenuController@actionDeleteBusiness');


Route::any('/admin/classes', 'AdminClassController@viewClasses');
Route::any('/admin/createclass', 'AdminClassController@viewCreateClass');
Route::any('/admin/classcategory', 'AdminClassController@viewClassCategoryManage');
Route::any('/admin/actionCreateClassCategory', 'AdminClassController@actionCreateClassCategory');
Route::any('/admin/actionCreateClass', 'AdminClassController@actionCreateClass');
Route::any('/admin/actionDeleteClassCategory/{cid}', 'AdminClassController@actionDeleteClassCategory');
Route::any('/admin/actionDeleteClass/{cid}', 'AdminClassController@actionDeleteClass');
Route::any('/admin/viewEditClass/{cid}', 'AdminClassController@viewEditClass');
Route::any('/admin/actionUpdateClass', 'AdminClassController@actionUpdateClass');


Route::any('/admin/viewInvoice/{uid}', 'AdminPaymentController@viewInvoice');
Route::any('/admin/actionSetInvoice', 'AdminPaymentController@actionSetInvoice');
Route::any('/admin/viewCoupon', 'AdminPaymentController@viewCoupon');
Route::any('/admin/actionCreateCoupon', 'AdminPaymentController@actionCreateCoupon');
Route::any('/admin/actionDeleteCoupon/{id}', 'AdminPaymentController@actionDeleteCoupon');
Route::any('/admin/planmanage', 'AdminPaymentController@viewPlanManage');
Route::any('/admin/actionPlanUpdate', 'AdminPaymentController@actionPlanUpdate');
Route::any('/admin/ajaxMonthPayment', 'AdminPaymentController@ajaxMonthPayment');
Route::any('/admin/payments', 'AdminPaymentController@viewPayments');

Route::any('/admin/viewCreateUser', 'AdminUserController@viewCreateUser');
Route::any('/admin/actionCreateUser', 'AdminUserController@actionCreateUser');
Route::any('/admin/users', 'AdminUserController@viewUsers');
Route::any('/admin/actionEditUser/{uid}', 'AdminUserController@viewEditUser');
Route::any('/admin/createcompany', 'AdminUserController@viewCreateCompany');
Route::any('/admin/viewEditCompany/{cid}', 'AdminUserController@viewEditCompany');
Route::any('/admin/formCreateCompany', 'AdminUserController@actionCreateCompany');
Route::any('/admin/actionEditCompany', 'AdminUserController@actionEditCompany');
Route::any('/admin/actionDeleteCompany/{cid}', 'AdminUserController@actionDeleteCompany');
Route::any('/admin/actionUpdateUser', 'AdminUserController@actionUpdateUser');


Route::any('/admin/dashboard', 'AdminMenuController@viewDashboard');
Route::any('/admin/reviews', 'AdminMenuController@viewReviews');
Route::any('/admin/locationmanage', 'AdminMenuController@viewLocationManage');
Route::any('/admin/activitymanage', 'AdminMenuController@viewActivityManage');
Route::any('/admin/studiomanage', 'AdminMenuController@viewStudioManage');
Route::any('/admin/amentitymanage', 'AdminMenuController@viewAmenityManage');
Route::any('/admin/citymanage', 'AdminMenuController@viewCityManage');
Route::any('/admin/company', 'AdminMenuController@viewCompany');

Route::any('/admin/actionCreateLocation', 'AdminPaymentController@actionCreateLocation');
Route::any('/admin/actionDeleteLocation/{cid}', 'AdminController@actionDeleteLocation');
Route::any('/admin/actionCreateActivity', 'AdminController@actionCreateActivity');
Route::any('/admin/actionDeleteActivity/{cid}', 'AdminController@actionDeleteActivity');
Route::any('/admin/actionCreateStudio', 'AdminController@actionCreateStudio');
Route::any('/admin/actionDeleteStudio/{cid}', 'AdminController@actionDeleteStudio');
Route::any('/admin/actionCreateAmenity', 'AdminController@actionCreateAmenity');
Route::any('/admin/actionDeleteAmenity/{cid}', 'AdminController@actionDeleteAmenity');
Route::any('/admin/actionCreateCity', 'AdminController@actionCreateCity');
Route::any('/admin/actionDeleteCity/{cid}', 'AdminController@actionDeleteCity');

Route::any('/admin/ajaxUploadGymLogo', 'AdminImageController@ajaxUploadGymLogo');
Route::any('/admin/ajaxUploadGymImage', 'AdminImageController@ajaxUploadGymImage');
Route::any('/admin/ajaxUploadCompanyLogo', 'AdminImageController@ajaxUploadCompanyLogo');
