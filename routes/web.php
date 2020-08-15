<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WebPageController@index');
Route::get('/viewsite', 'WebPageController@index');
Route::get('/FIRST PAGE', 'WebPageController@index')->name('firstpage');
Route::get('/MAINTANANCE', 'WebPageController@getFacilityPage')->name('maintanance');
Route::get('/listing/{categoryId}', 'WebPageController@getListingPage');
Route::get('/sublisting/{subcategoryId}', 'WebPageController@getSubListingPage');
Route::get('/ABOUT US', 'WebPageController@getAboutUsPage')->name('about');
Route::get('/ViewContent/{prvTab}/{postId}', 'WebPageController@viewContent');
Route::get('/ViewBrowsure/{postId}', 'WebPageController@getPDFBrowsure')->name('viewBrowsure');

Route::POST('/contactFormFooter', 'WebPageController@bindSendEmailWithAjaxPostRequest');

Auth::routes();

Route::group(['prefix' => 'ekadi/admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/gettingJsonVisitorPageView', 'HomeController@gettingJsonVisitorPageView');
    Route::get('/', 'HomeController@index')->name('dashboard');
    // Route::get('/dashboard/getAjaxChartBarData', 'HomeController@setAjaxChartBarData');

    // category
    Route::put('/category', 'CategoriesController@updateTitle')->name('category.updateTitle');
    Route::delete('/category', 'CategoriesController@deleteTitle')->name('category.deleteTitle');
    Route::resource('/category', 'CategoriesController');

    // sub category
    Route::put('/subcategory', 'SubCategoriesController@updateSubCategory')->name('subcategory.updateSubCategory');
    Route::delete('/subcategory', 'SubCategoriesController@deleteSubCategory')->name('subcategory.deleteSubCategory');
    Route::resource('/subcategory', 'SubCategoriesController');

    // post
    Route::POST('/posts/filterByPost', 'PostsController@filterResultPost')->name('posts.filterPostsResult');
    Route::GET('/posts/getSubCategory/{id}', 'PostsController@getSubCategoryIdByCategoryId');
    Route::POST('/posts/deletePosts', 'PostsController@deletePosts')->name('posts.deletePosts');
    Route::GET('/posts/showPostById/{id}', 'PostsController@showPost');
    Route::resource('/posts', 'PostsController');

    // slide Show
    Route::POST('/slideshowUpdate', 'SlideshowController@updateSlideShowImage')->name('slideshow.updateSlideShowImage');
    Route::POST('/slideShowDelete', 'SlideshowController@deleteSlideShowImage')->name('slideshow.deleteSlideShowImage');
    Route::resource('/slideshow', 'SlideshowController');

    // profile
    // Route::get('/profile/checkEmailValid/{email}', 'ProfileController@checkEmailAddressValidator');
    Route::put('/profile/changeNewPassword', 'ProfileController@changeNewPassword')->name('profile.changeNewPassword');
    Route::POST('/profile/generatingToken', 'ProfileController@generatingToken');
    Route::put('/profile', 'ProfileController@editUserNameAndEmail')->name('profile.updateNameAndEmail');
    Route::resource('/profile', 'ProfileController');

    // manage admin
    Route::GET('/manageAdmin/checkUserNameAndEmailAjax', 'ManageAdminController@checkUserNameAndEmailAjax');
    Route::DELETE('/manageAdmin/deleteAdminUserById', 'ManageAdminController@deleteAdminById')->name('manageAdmin.deleteAdminById');
    Route::resource('/manageAdmin', 'ManageAdminController');

    // manage browsure
    Route::DELETE('/manageBrowsure/deleteBrowsure', 'ManageBrowsureController@deleteBrowsure')->name('manageBrowsure.deleteBrowsure');
    Route::GET('/manageBrowsure/getBrowsureEditRequest/{postId}', 'ManageBrowsureController@getAjaxEditProductList');
    Route::GET('/manageBrowsure/getBrowsurePDFPreview/{postId}', 'ManageBrowsureController@getPDFBrowsure');
    Route::resource('/manageBrowsure', 'ManageBrowsureController');

    // manage Gallery
    Route::PUT('/manageGallery/updatePhoto', 'imagesController@updateImageGallery')->name('manageGallery.updateImage');
    Route::delete('/manageGallery/deletePhoto', 'imagesController@deleteImageGallery')->name('manageGallery.deleteImage');
    Route::GET('/manageGallery/{getPostId}', 'imagesController@onChangeByPostIdFromListingParent');
    Route::resource('/manageGallery', 'imagesController');
});
