<?php

class TeacherController extends BaseController
{
  public static function getTeachers()
  {
      return Teacher::where('university_id', '=', Auth::id())->get();
  }

  public function showView ()
  {
      return View::make('university.add_teacher');
  }

    public function showHome()
    {
        return View::make('teacher.home');
    }
    public function showProfile()
    {
        return View::make('teacher.profile');
    }

    public function showSubjectDetails()
    {
        return View::make('teacher.subject_details');
    }

    public function showFarmReport()
    {
        return View::make('teacher.farm_report');
    }

  public function showAllTeachersView ()
  {
      return View::make('university.show_all_teachers')->with(array( 'teachers' => $this->getTeachers()));
  }

  public function addTeacher()
  {
      $user = new User;
      $user->user = Input::get('email');
      $user->password = Hash::make(Input::get('email'));
      $user->rank = "teacher";

      try
      {
          $user->save();
      }
      catch(MongoDuplicateKeyException $e)
      {
          return Redirect::back()->withErrors(array( 'error' => 'This email is already registered in our system'));
      }

      $user = User::first(['user' => $user->user]);

      $teacher = new Teacher;
      $teacher->_id = $user->_id;
      $teacher->university_id = Auth::id();
      $teacher->name = Input::get('name');
      $teacher->last_name = Input::get('last_name');
      $teacher->phone = Input::get('phone');
      $teacher->cellphone = Input::get('cellphone');
      $teacher->email = Input::get('email');
      $teacher->save();

      return Redirect::to('add_teacher')->with('message', 'Teacher successfully registered!');
  }

}
