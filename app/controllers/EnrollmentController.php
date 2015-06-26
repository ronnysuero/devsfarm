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
      return View::make('university.show_all_enrollment')->with(array( 'assignments' => 'Invalid Email or Password'));
  }

}
