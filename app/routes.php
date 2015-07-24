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

Route::group(array(), function()
{
	// HTTP GET
	Route::get('/', 'UserController@showView');

	Route::get(Lang::get('routes.forget_password'), 'UserController@showForgetPasswordView');

	Route::get(Lang::get('routes.forget_password').'/{token}', 'UserController@confirmToken');

	Route::get(Lang::get('routes.reset_password'), 'UserController@showResetPasswordView');

	Route::get(Lang::get('routes.register'), 'UserController@showRegisterView');

	Route::get(Lang::get('routes.register_university'), 'UniversityController@showRegisterUniversityView');

	// HTTP POST
	Route::post(Lang::get('routes.login'), 'UserController@login');

	Route::post(Lang::get('routes.register_student'), 'StudentController@registerStudent');

	Route::post(Lang::get('routes.register_university'), 'UniversityController@registerUniversity');

	Route::post(Lang::get('routes.forget_password'), 'UserController@forgetPassword');

	Route::post(Lang::get('routes.reset_password'), 'UserController@resetPassword');
});


Route::group(array('before' => 'auth|university'), function()
{
	// HTTP GET
	Route::get(Lang::get('routes.university'), 'UniversityController@showHome');

	Route::get(Lang::get('routes.university_profile'), 'UniversityController@showProfile');

	Route::get(Lang::get('routes.add_subject'), 'SubjectController@showView');

	Route::get(Lang::get('routes.show_all_subjects'), 'SubjectController@showAllSubjectsView');

	Route::get(Lang::get('routes.add_teacher'), 'TeacherController@showView');

	Route::get(Lang::get('routes.show_all_teachers'), 'TeacherController@showAllTeachersView');

	Route::get(Lang::get('routes.add_enrollment'), 'EnrollmentController@showView');

	Route::get(Lang::get('routes.show_all_enrollment'), 'EnrollmentController@showAllAssignmentsView');

	Route::get(Lang::get('routes.add_section'), 'SectionController@showView');

	Route::get(Lang::get('routes.show_all_sections'), 'SectionController@showAllSectionsView');

	// HTTP POST
	Route::post(Lang::get('routes.add_subject'), 'SubjectController@addSubject');

	Route::post(Lang::get('routes.add_teacher'), 'TeacherController@addTeacher');

	Route::post(Lang::get('routes.add_section'), 'SectionController@addSection');

	Route::post(Lang::get('routes.update_university'), 'UniversityController@update');

	Route::post(Lang::get('routes.update_teacher'), 'TeacherController@update');

	Route::post(Lang::get('routes.update_section'), 'SectionController@update');

	Route::post(Lang::get('routes.update_subject'), 'SubjectController@update');

	Route::post(Lang::get('routes.find_teacher'), 'TeacherController@find');

	Route::post(Lang::get('routes.find_subject'), 'SubjectController@find');

	Route::post(Lang::get('routes.find_section'), 'SectionController@find');

	Route::post(Lang::get('routes.find_unused_section'), 'SectionController@findUnusedSection');

	Route::post(Lang::get('routes.add_enrollment'), 'EnrollmentController@addEnrollment');

});

Route::group(array('before' => 'auth|teacher'), function()
{
	// HTTP GET
	Route::get(Lang::get('routes.teacher'), 'TeacherController@showHome');

	Route::get(Lang::get('routes.teacher_profile'), 'TeacherController@showProfile');

	Route::get(Lang::get('routes.subject_details'), 'TeacherController@showSubjectDetails');

	Route::get(Lang::get('routes.farm_report'), 'TeacherController@showFarmReport');

    Route::post(Lang::get('routes.update_teacher'), 'TeacherController@updateTeacher');

    Route::get(Lang::get('routes.section_codes'), 'SectionController@showAllSectionsCodesView');

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
	// HTTP GET  
	Route::get('chat', 'ChatController@showView');
	
	Route::get(Lang::get('routes.inbox'), 'MessageController@showInboxView');

	Route::get(Lang::get('routes.sent'), 'MessageController@showMessageSentView');
	
	Route::get(Lang::get('routes.archived'), 'MessageController@showMessageArchivedView');
	
	Route::get(Lang::get('routes.unread'), 'MessageController@showMessageUnreadView');

	Route::get(Lang::get('routes.logout'), 'UserController@logout');

	Route::get(Lang::get('show_image'), function() 
	{
		$src = Input::get('src');

		$cacheimage = Image::cache(function($image) use ($src) {
			return $image->make($src);
		}, 1, false); // one minute cache expiry

		return Response::make($cacheimage, 200, array('Content-Type' => 'image/jpeg'));
	});

	// HTTP POST
	Route::post(Lang::get('routes.send_message'), 'MessageController@sendMessage');

	Route::post(Lang::get('routes.find_message'), 'MessageController@find');

	Route::post(Lang::get('routes.drop_message'), 'MessageController@drop');

	Route::post(Lang::get('routes.mark_read_message'), 'MessageController@markRead');

	Route::post(Lang::get('routes.archived_message'), 'MessageController@archived');
	
	Route::post(Lang::get('routes.find_chat'), 'ChatController@find');

});
