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
	Route::post(Lang::get('routes.update_section'), 'SectionController@update');
	Route::post(Lang::get('routes.update_subject'), 'SubjectController@update');
	Route::post(Lang::get('routes.find_teacher'), 'TeacherController@find');
	Route::post(Lang::get('routes.find_subject'), 'SubjectController@find');
	Route::post(Lang::get('routes.find_section'), 'SectionController@find');
	Route::post(Lang::get('routes.find_unused_section'), 'SectionController@findUnusedSection');
	Route::post(Lang::get('routes.add_enrollment'), 'EnrollmentController@addEnrollment');
	Route::post(Lang::get('routes.generate_user'), 'UserController@generateUser');
	Route::post(Lang::get('routes.drop_section'), 'SectionController@drop');    
	Route::post(Lang::get('routes.drop_subject'), 'SubjectController@drop');
	Route::post(Lang::get('routes.drop_teacher'), 'TeacherController@drop');
	Route::post(Lang::get('routes.unlink_enrollment'), 'EnrollmentController@unlink');
	Route::post(Lang::get('routes.update_teachers'), 'TeacherController@update');
});

Route::group(array('before' => 'auth|teacher'), function()
{
	// HTTP GET
	Route::get(Lang::get('routes.teacher'), 'TeacherController@showHome');
	Route::get(Lang::get('routes.teacher_profile'), 'TeacherController@showProfile');
	Route::get(Lang::get('routes.section_codes'), 'SectionCodeController@showAllSectionsCodesView');
	Route::get(Lang::get('routes.approval'), 'TeacherController@showApprovalStudentView');
	Route::get(Lang::get('routes.add_teamleader'), 'TeacherController@showAddTeamleaderView');
	Route::get(Lang::get('routes.show_teamleader'), 'TeacherController@showAllTeamleaderView');

	// HTTP POST
	Route::post(Lang::get('routes.find_subject_section'), 'SectionController@getSubjectSections');
	Route::post(Lang::get('routes.create_section_code'), 'SectionCodeController@addSectionCode');
	Route::post(Lang::get('routes.get_section_groups'), 'GroupController@findGroupBySection');
	Route::post(Lang::get('routes.find_member_information'), 'GroupController@findMemberInformation');
	Route::post(Lang::get('routes.get_farm_report'), 'GroupController@getFarmReport');
	Route::post(Lang::get('routes.approve_enroll'), 'PendingEnrollmentController@approve');
	Route::post(Lang::get('routes.add_teamleader'), 'TeacherController@addTeamleader');
	Route::post(Lang::get('routes.drop_teamleader'), 'SectionCodeController@dropTeamleaderSectionCode');
	Route::post(Lang::get('routes.update_teacher'), 'TeacherController@updateTeacher');
	
});

Route::group(array('before' => 'auth|student'), function()
{
    // HTTP GET
    Route::get(Lang::get('routes.student'), 'StudentController@showHome');
    Route::get(Lang::get('routes.find_Group'), 'GroupController@findGroup');
    Route::get(Lang::get('routes.register_group'), 'GroupController@registerGroup');
    Route::get(Lang::get('routes.student_profile'), 'StudentController@showProfile');
    Route::get(Lang::get('routes.show_groups'), 'GroupController@showAllGroupView');
    Route::get(Lang::get('routes.join_to_group'), 'GroupController@joinToGroup');
    Route::get(Lang::get('routes.enroll_section'), 'PendingEnrollmentController@showEnrollSection');

    // HTTP POST
    Route::post(Lang::get('routes.findSection'), 'SectionController@findSection');
    Route::post(Lang::get('routes.register_group'), 'GroupController@addGroup');
    Route::post(Lang::get('routes.rated'), 'AssignmentController@rated');
    Route::post(Lang::get('routes.update_student'), 'StudentController@updateStudent');
    Route::post(Lang::get('routes.register_assignment'), 'AssignmentController@addAssignment');
    Route::post(Lang::get('routes.find_Group_By_Section'), 'GroupController@findGroupBySection');
    Route::post(Lang::get('routes.find_Group'), 'GroupController@findGroup');
    Route::post(Lang::get('routes.join_to_group'), 'GroupController@addStudentToGroup');
    Route::post(Lang::get('routes.find_student'), 'StudentController@find');
    Route::post(Lang::get('routes.find_students'), 'GroupController@find_students');
    Route::post(Lang::get('routes.drop_tasks'), 'AssignmentController@drop');
    Route::post(Lang::get('routes.update_task'), 'AssignmentController@updateTask');
    Route::post(Lang::get('routes.drop_group'), 'GroupController@drop');
    Route::post(Lang::get('routes.update_group'), 'GroupController@findupdateGroup');
    Route::post(Lang::get('routes.find_task'), 'AssignmentController@findTask');
    Route::post(Lang::get('routes.enroll_section'), 'PendingEnrollmentController@enrollSection');
	Route::post(Lang::get('routes.assign'), 'AssignmentController@assign');
});

Route::group(array('before' => 'auth'), function()
{
	// HTTP GET
	Route::get(Lang::get('routes.chat'), 'ChatController@showView');
	Route::get(Lang::get('routes.inbox'), 'MessageController@showInboxView');
	Route::get(Lang::get('routes.mail_sent'), 'MessageController@showMessageSentView');    
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
	Route::post(Lang::get('routes.drop_enroll'), 'PendingEnrollmentController@drop');
	Route::post(Lang::get('routes.find_student'), 'StudentController@find');
});
