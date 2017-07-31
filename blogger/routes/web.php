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

/*Route::get('/', function () {
    return view('Auth.login');
});*/

Route::get('/','HomeController@index');

 Auth::routes();

Route::get('home/{category?}', 'HomeController@index')->name('home');

Route::post('addPost','HomeController@addPost');

Route::post('deletePost','HomeController@deletePost');

Route::post('editPost','HomeController@editPost');

Route::get('create-blog','HomeController@create');

Route::get('view/{slug}','HomeController@viewBlog');

Route::post('view/addComment','HomeController@addComment');

Route::post('view/addLike','HomeController@addLike');

Route::get('edit/{slug}','HomeController@edit');

Route::post('edit/saveEditPost','HomeController@saveEditedPost');

Route::get('profile','HomeController@profileImage');
Route::post('updateUserImage','HomeController@updateProfileImage');

Route::post('getLikesUsers','HomeController@getLikesUsers');
Route::post('getCommentsUsers','HomeController@getCommentsUsers');

Route::post('edit/updateBlogImage','HomeController@updateBlogImage');

Route::post('postBlogImages','HomeController@addBlogImages');