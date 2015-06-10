<?php

class AssignmentController extends BaseController
{
  public function showView ()
  {
      return View::make('university.add_assignment')->with(array( 'teachers' => TeacherController::getTeachers(),
                                                                  'subjects' => SubjectController::getSubjects()));
  }

  public function showAllAssignmentsView ()
  {
      return View::make('university.show_all_assignments')->with(array( 'assignments' => 'Invalid Email or Password'));
  }

}
