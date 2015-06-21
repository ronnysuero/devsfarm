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

// SET DEFAULT LANGUAGE BROWSER
App::setLocale(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));


// HTTP GET
Route::get('/', 'UserController@showView');

Route::get('register_student', 'StudentController@showRegisterView');

Route::get('register_university', 'UniversityController@showRegisterUniversityView');

Route::get('logout', 'UserController@logout')->before('auth');


// HTTP POST
Route::post('login', 'UserController@login');

Route::post('register_student', 'StudentController@registerStudent');

Route::post('register_university', 'UniversityController@registerUniversity');


Route::group(array('before' => 'auth|university'), function()
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

  // HTTP POST
  Route::post('add_subject', 'SubjectController@addSubject');

  Route::post('add_teacher', 'TeacherController@addTeacher');
});

Route::group(array('before' => 'auth|teacher'), function()
{

  Route::get('teacher', 'TeacherController@showHome');
  Route::get('teacher_profile', 'TeacherController@showProfile');
  Route::get('subject_details', 'TeacherController@showSubjectDetails');
});

Route::group(array('before' => 'auth|student'), function()
{
  // HTTP GET
  Route::get('student', 'StudentController@showHome');

  // HTTP POST

});

Route::group(array('before' => 'auth'), function()
{
    Route::get('show_all_messages', 'MessageController@showAllMessagesView');

    Route::get('send_message', 'MessageController@showSendMessageView');

    Route::get('show_message', 'MessageController@showMessageView');
});
