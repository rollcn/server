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

Route::group(array('prefix' => 'api','before' => 'csrf'),function(){
	Route::controller('FindMovie','LittleMovie\MovieController');
	Route::controller('Topic','LittleMovie\TopicController');
	Route::controller('Collect','LittleMovie\CollectController');
	Route::controller('Comment','LittleMovie\CommentController');
	Route::controller('User','LittleMovie\UserController');
});
/*Route::get('/home/id={id}/name={name}', function($id,$name){
	return $id.$name;
});

Route::any('movie',function(){
	//abort(500,'error');
	return 'dianying';
});*/

//Route::resource('movie', 'LittleMovie\MovieController');

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('movie',function(){
	return 'dianying';
});
*/