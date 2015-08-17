<?php

class EnrollmentController extends BaseController
{
	/**
	 * Show add enrollment view
	 * 
	 * @return View
	 */
	public function showView ()
	{
		return View::make('university.add_enrollment')->with(array( 'teachers' => TeacherController::getTeachers(),
						  											'subjects' => SubjectController::getSubjects(),
						  											'stats' => MessageController::getStats(),
														  			'unreadMessages' => MessageController::unReadMessages()));
	}

	/**
	 *	Show all assigments view
	 * 
	 * @return View
	 */
	public function showAllAssignmentsView ()
	{
		return View::make('university.show_all_enrollment')->with(array( 'teachers' => TeacherController::getTeachers(),
																		 'stats' => MessageController::getStats(),
														  				 'unreadMessages' => MessageController::unReadMessages()));
	}

	/**
	 * Link a section with a teacher
	 * 
	 * @return View
	 */
	public function addEnrollment()
	{
		$subject = Subject::find(Input::get('subject'));
		$section = $subject->sections()->find(new MongoId(Input::get('section')));
		
		Teacher::find(Input::get('teacher'))->push('subjects_id', new MongoId($subject->_id), true);
		Teacher::find(Input::get('teacher'))->push('sections_id', new MongoId($section->_id), true);	

		$section->is_free = false;
		$section->save();
		
		return Redirect::to(Lang::get('routes.add_enrollment'))->with('message', Lang::get('add_enroll.success'));  
	}

	/**
	 * Unlink a section with a teacher 
	 * 
	 * @return JSON Ajax
	 */
	public function unlink()
	{
		if(Request::ajax())
		{
			$subject = Subject::find(Input::get('subject_id'));
			$teacher = Teacher::find(Input::get('teacher_id'));
			$teacher->pull('sections_id', new MongoId(Input::get('section_id')));
			$section = $subject->sections()->find(Input::get('section_id'));
			$section->is_free = true;
			$section->save();

			if($subject->sections()->whereIn('_id', $teacher->sections_id)->count() === 0)
				$teacher->pull('subjects_id', new MongoId(Input::get('subject_id')));

			return Response::json("00");
		}
	}

}
