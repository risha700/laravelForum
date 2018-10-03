<?php


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();




Route::get('/home', 'HomeController@index')->name('home');


Route::get('/threads/search', 'SearchController@show')->name('search');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');

Route::get('/threads', 'ThreadController@index')->name('forum');
Route::get('/threads/create', 'ThreadController@create')->name('create');
Route::get('/threads/{channel}', 'ThreadController@index')->name('channel');
//Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/threads', 'ThreadController@store')->middleware('confirmed');
Route::post('/threads/{thread}/favorites', 'ThreadController@likeThread');
Route::delete('/threads/{thread}/favorites', 'FavoriteController@destroy');
Route::patch('/threads/{channel}/{thread}', 'ThreadController@update')->name('thread.update ');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');


Route::patch('/lock/{channel}/{thread}/', 'ThreadController@lock')->name('thread.lock')->middleware('admin');
Route::delete('/lock/{channel}/{thread}/', 'ThreadController@unlock')->name('thread.unlock')->middleware('admin');


Route::post('/threads/{channel}/{thread}/subscription', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscription', 'ThreadSubscriptionController@destroy')->middleware('auth');

// Route::resource('/threads', 'ThreadController');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::delete('replies/{reply}', 'ReplyController@destroy');
Route::patch('replies/{reply}', 'ReplyController@update');

//Route::post('/threads/{thread}/favorites', 'FavoriteController@show');
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
//Route::delete('/threads/{thread}/favorites', 'FavoriteController@update');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');



//Route::delete('/threads/{thread}/favorites', 'FavoriteController@update');





Route::get('/profile/{user}', 'ProfileController@index')->name('profile');



Route::delete('profile/{user}/notifications/{notification}', 'UserNotificationController@destroy');
Route::get('profile/{user}/notifications', 'UserNotificationController@index');

Route::get('api/users', 'Api\UserController@index')->name('avatar');
Route::post('replies/{reply}/best', 'BestReplyController@store');

Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store');

Route::get('register/activate', 'Auth\RegisterConfirmationController@index');



