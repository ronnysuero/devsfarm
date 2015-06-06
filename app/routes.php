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

Route::get('show_all_subjects', 'UniversityController@showAllSubjectsView')->before('auth|university');

Route::get('add_teacher', 'UniversityController@showAddTeacherView')->before('auth|university');

Route::get('show_all_teachers', 'UniversityController@showAllTeachersView')->before('auth|university');

Route::get('add_assignment', 'UniversityController@showAddAssignmentView')->before('auth|university');

Route::get('show_all_assignments', 'UniversityController@showAllAssignmentsView')->before('auth|university');

// HTTP POST
Route::post('login', 'UserController@login');

Route::post('register', 'UserController@register');

Route::post('add_subject', 'UniversityController@addSubject')->before('auth');

Route::post('add_teacher', 'UniversityController@addTeacher')->before('auth');
