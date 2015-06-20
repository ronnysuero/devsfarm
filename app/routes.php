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
Route::get('/', 'UserController@showView');

Route::get('register_student', 'StudentController@showRegisterView');

Route::get('register_university', 'UniversityController@showRegisterUniversityView');

Route::get('logout', 'UserController@logout')->before('auth');


// HTTP POST
Route::post('login', 'UserController@login');

Route::post('register_student', 'StudentController@registerStudent');

Route::post('register_university', 'UniversityController@registerUniversity');


Route::group(array('' => ''), function()
{
  // HTTP GET
  Route::get('university', 'UniversityController@showHome');

  Route::get('university_profile', 'UniversityController@showProfile');

  Route::get('add_subject', 'SubjectController@showView');

  Route::get('show_all_subjects', 'SubjectController@showAllSubjectsView');

  Route::get('add_teacher', 'TeacherController@showView');

  Route::get('show_all_teachers', 'TeacherController@showAllTeachersView');

  Route::get('add_assignment', 'AssignmentController@showView');

  Route::get('show_all_assignments', 'AssignmentController@showAllAssignmentsView');

  Route::get('show_all_messages', 'MessageController@showAllMessagesView');

  Route::get('send_message', 'MessageController@showSendMessageView');

  Route::get('show_message', 'MessageController@showMessageView');

  // HTTP POST
  Route::post('add_subject', 'SubjectController@addSubject');

  Route::post('add_teacher', 'TeacherController@addTeacher');
});


Route::group(array('before' => 'auth|teacher'), function()
{

});

Route::group(array('before' => 'auth|student'), function()
{
  // HTTP GET
  Route::get('student', 'StudentController@showHome');

  // HTTP POST

});
