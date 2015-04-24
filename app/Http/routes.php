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

Route::group(array('prefix' => 'api'),function(){
	Route::controller('FindMovie','LittleMovie\MovieController');
	Route::controller('CreateTopic','LittleMovie\TopicController');
});
Route::get('/home/id={id}/name={name}', function($id,$name){
	return $id.$name;
});

Route::any('movie',function(){
	return 'dianying';
});
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