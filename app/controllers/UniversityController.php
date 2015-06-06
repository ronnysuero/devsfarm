<?php

class UniversityController extends BaseController
{
    public function getTeachers()
    {
        return Teacher::where('university_id', '=', Auth::id())->get();
    }
    public function getSubjects()
    {
        return Subject::where('university_id', '=', Auth::id())->get();
    }

    public function showHome()
    {
        $teachers = $this->getTeachers();
        $subjects = $this->getSubjects();
        return View::make('university.home')->with(array( 'subjects' => $subjects,
                                                            'teachers' => $teachers));
    }

    public function showProfile()
    {
        return View::make('university.profile');
    }

    public function addSubject()
    {

      $university = University::where('email', '=', Auth::user()->user)->first();

      $subject = new Subject;
      $subject->name = Input::get('subject_name');
      $subject->university_id = Auth::id();
      $subject->division = Input::get('division');
      $sections = explode(',', Input::get('section'));
      $trimList = array();

      foreach($sections as $section)
      {
        array_push($trimList, trim($section));
      }

      $subject->sections = $trimList;
      $subject->save();

      return Redirect::to('add_subject')->with('message', 'Subject successfully registered!');
    }

    public function showAddSubjectView()
    {
        return View::make('university.add_subject');
    }

    public function showAllSubjectsView ()
    {
        $subjects = $this->getSubjects();
        return View::make('university.show_all_subjects')->with(array( 'subjects' => $subjects));
    }

    public function addTeacher()
    {
        $university = University::where('email', '=', Auth::user()->user)->first();

        $teacher = new Teacher;
        $teacher->university_id = Auth::id();
        $teacher->name = Input::get('name');
        $teacher->last_name = Input::get('last_name');
        $teacher->phone = Input::get('phone');
        $teacher->cellphone = Input::get('cellphone');
        $teacher->email = Input::get('email');
        $teacher->_id = Input::get('email');
        $teacher->save();

        return Redirect::to('add_teacher')->with('message', 'Teacher successfully registered!');
    }

    public function showAddTeacherView ()
    {
        return View::make('university.add_teacher');
    }

    public function showAllTeachersView ()
    {
        $teachers = $this->getTeachers();
        return View::make('university.show_all_teachers')->with(array( 'teachers' => $teachers));
    }

    public function showAddAssignmentView ()
    {
        $teachers = $this->getTeachers();
        $subjects = $this->getSubjects();
        return View::make('university.add_assignment')->with(array( 'teachers' => $teachers,
                                                                    'subjects' => $subjects));;
    }

    public function showAllAssignmentsView ()
    {
        return View::make('university.show_all_assignments')->with(array( 'assignments' => 'Invalid Email or Password'));
    }
}
