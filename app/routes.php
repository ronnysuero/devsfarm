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

// HTTP GET
Route::get('/', 'DefaultController@showView');

Route::get('register', 'RegisterController@showView');

Route::get('home', 'HomeController@showView')->before('auth');

Route::get('logout', 'UserController@logout')->before('auth');

// HTTP POST
Route::post('login', 'UserController@login');
