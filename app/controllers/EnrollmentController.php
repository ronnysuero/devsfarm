<?php

class EnrollmentController extends BaseController
{
  public function showView ()
  {
      return View::make('university.add_enrollment')->with(array( 'teachers' => TeacherController::getTeachers(),
                                                                  'subjects' => SubjectController::getSubjects()));
  }

  public function showAllAssignmentsView ()
  {
    return View::make('university.show_all_enrollment')->with(array( 'teachers' => TeacherController::getTeachers()));
  }

  public function addEnrollment()
  {
  	$subject = Subject::where('_id', '=', new MongoId(Input::get('_id')))->first();
  	$section = $subject->sections()->where('_id', '=', new MongoId(Input::get('section')))->first();
    
	  Teacher::where('_id', '=', new MongoId(Input::get('teacher_id')))->push('subjects_id', new MongoId($subject->_id), true);
  	Teacher::where('_id', '=', new MongoId(Input::get('teacher_id')))->push('sections_id', new MongoId($section->_id), true);	

	  $section->is_free = false;
	  $section->save();
  
	  return Redirect::to(Lang::get('routes.add_enrollment'))->with('message', Lang::get('add_enroll.success'));  
  }
}
