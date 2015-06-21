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
$langs_availables = array('es', 'en');
$lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if (in_array($lang_browser, $langs_availables))
  App::setLocale($lang_browser);
else
  App::setLocale('en'); //set default english


// HTTP GET
Route::get('/', 'UserController@showView');

Route::get(Lang::get('routes.register'), 'StudentController@showRegisterView');

Route::get(Lang::get('routes.register_university'), 'UniversityController@showRegisterUniversityView');

Route::get(Lang::get('routes.logout'), 'UserController@logout')->before('auth');


// HTTP POST
Route::post(Lang::get('routes.login'), 'UserController@login');

Route::post(Lang::get('routes.register_student'), 'StudentController@registerStudent');


Route::group(array('before' => 'auth|university'), function()
{
  // HTTP GET
  Route::get(Lang::get('routes.university'), 'UniversityController@showHome');

  Route::get(Lang::get('routes.university_profile'), 'UniversityController@showProfile');

  Route::get(Lang::get('routes.add_subject'), 'SubjectController@showView');

  Route::get(Lang::get('routes.show_all_subjects'), 'SubjectController@showAllSubjectsView');

  Route::get(Lang::get('routes.add_teacher'), 'TeacherController@showView');

  Route::get(Lang::get('routes.show_all_teachers'), 'TeacherController@showAllTeachersView');

  Route::get(Lang::get('routes.add_assignment'), 'AssignmentController@showView');

  Route::get(Lang::get('routes.show_all_assignments'), 'AssignmentController@showAllAssignmentsView');

  // HTTP POST
  Route::post(Lang::get('routes.add_subject'), 'SubjectController@addSubject');

  Route::post(Lang::get('routes.add_teacher'), 'TeacherController@addTeacher');
});

Route::group(array('before' => 'auth|teacher'), function()
{
  // HTTP GET
    Route::get(Lang::get('routes.teacher'), 'TeacherController@showHome');

    Route::get(Lang::get('routes.teacher_profile'), 'TeacherController@showProfile');

    Route::get(Lang::get('routes.subject_details'), 'TeacherController@showSubjectDetails');

    Route::get(Lang::get('routes.farm_report'), 'TeacherController@showFarmReport');

  // HTTP POST
});

Route::group(array('before' => 'auth|student'), function()
{
  // HTTP GET
  Route::get(Lang::get('routes.student'), 'StudentController@showHome');

  // HTTP POST

});

Route::group(array('before' => 'auth'), function()
{
    Route::get(Lang::get('routes.show_all_messages'), 'MessageController@showAllMessagesView');

    Route::get(Lang::get('routes.send_message'), 'MessageController@showSendMessageView');

    Route::get(Lang::get('routes.show_message'), 'MessageController@showMessageView');
});
