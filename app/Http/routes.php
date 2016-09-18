<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [
    'uses' => 'PostController@getDashboard',
    'as' => 'dashboard',
    'middleware' => 'auth'
]);

Route::post('/signin', [
    'uses' => 'UserController@postSignIn',
    'as' => 'signin'
]);

Route::post('/signup', [
    'uses' => 'UserController@postSignUp',
    'as' => 'signup'
]);

Route::get('/account', [
    'uses' => 'UserController@getAccount',
    'as' => 'account'
]);

Route::post('/account/update', [
    'uses' => 'UserController@postSaveAccount',
    'as' => 'account.save'
]);

Route::post('/edit', [
    'uses' => 'PostController@postEditPost',
    'as' => 'edit',
    'middleware' => 'auth'
]);

Route::get('/images/posts/{filename}', [
    'uses' => 'ImageController@getPostImage',
    'as' => 'post.image'
]);

Route::get('/images/users/{filename}', [
    'uses' => 'ImageController@getUserImage',
    'as' => 'user.image'
]);

Route::post('/like', [
    'uses' => 'PostController@postLikePost',
    'as' => 'post.like'
]);

Route::get('/logout', [
    'uses' => 'UserController@getLogout',
    'as' => 'logout',
]);

Route::post('/posts/create', [
    'uses' => 'PostController@postCreatePost',
    'as' => 'post.create',
    'middleware' => 'auth'
]);

Route::get('/posts/delete/{post_id}', [
    'uses' => 'PostController@getDeletePost',
    'as' => 'post.delete',
    'middleware' => 'auth'
]);

Route::post('/posts/image/upload', [
    'uses' => 'PostController@postStorePostImage',
    'as' => 'post.image.upload'
]);

Route::get('/users/{user_id}', [
    'uses' => 'UserController@getUser',
    'as' => 'user',
    'middleware' => 'auth'
]);

Route::get('/users/image/{filename}', [
    'uses' => 'UserController@getUserImage',
    'as' => 'account.image'
]);