<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('chat/exit/user/{user}', 'ChatController@exitChat');
Route::get('chat/getChatInfo/{chat}', 'ChatController@getChatInfo');
Route::group(array('before' => 'exitChat'), function()
{
    Route::get('isUserOnline', 'UserController@isUserOnline');
    Route::get('chat/createChat', 'ChatController@createChat');
    Route::get('chat/getAllPublicChats', array('before' => 'auth', 'uses' => 'ChatController@getAllPublicChats'));
    Route::get('chat/joinChat/{chat}', 'ChatController@joinChat');
    Route::post('chat/getChat/{chat}', 'ChatController@getChat');
    Route::get('showFriends', array('before' => 'auth', 'uses' => 'UserController@showAllFriends'));
    Route::post('deleteFriend/{friend}', 'UserController@deleteFriend');
    Route::post('acceptFriendship/{user}', array('before' => 'auth', 'uses' => 'UserController@acceptFriendship'));
    Route::post('rejectFriendship/{user}', array('before' => 'auth', 'uses' => 'UserController@rejectFriendship'));
    Route::post('friendRequests', array('before' => 'auth', 'uses' => 'UserController@friendRequests'));
    Route::post('friends/{friend}', array('before' => 'auth', 'uses' => 'UserController@inviteFriend'));
    Route::resource('message', 'MessageController');
    Route::post('message/sendMessage/{message}', 'MessageController@sendMessage');
    Route::get('showUsers', array('before' => 'auth', 'uses' => 'UserController@showAllUsers'));
    Route::any('logout', 'UserController@logout');
    Route::get('loginform', 'UserController@loginform');
    Route::post('login', 'UserController@login');
    Route::get('register' ,'UserController@create');
    Route::resource('chat', 'ChatController');
    Route::resource('album', 'AlbumController');
    Route::resource('user', 'UserController');
    Route::resource('picture', 'PictureController');
    Route::get('/', 'HomeController@index');
});

