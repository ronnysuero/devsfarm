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
Route::get('/', 'LoginController@showView');

Route::get('register', 'UserController@showRegisterView');

Route::get('student', 'StudentController@showHome')->before('auth');

Route::get('logout', 'UserController@logout')->before('auth');

// HTTP GET UNIVERSITY
Route::get('university', 'UniversityController@showHome')->before('auth|university');

Route::get('university_profile', 'UniversityController@showProfile')->before('auth|university');

Route::get('add_subject', 'UniversityController@showAddSubjectView')->before('auth|university');

// HTTP POST
Route::post('login', 'UserController@login');

Route::post('register', 'UserController@register');

Route::post('add_subject', 'UniversityController@addSubject')->before('auth|university');
