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
      $user->user = strtolower(Input::get('email'));
      $user->password = Hash::make(Input::get('email'));
      $user->rank = "teacher";
      $user->last_activity = null;

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
      $teacher->email = strtolower(Input::get('email'));

      if (Input::hasFile('photo'))
      {
          $file = Input::file('photo');
          $photoname = uniqid();
          $file->move(storage_path() . '/photos/imagesprofile', $photoname.'.'.$file->guessClientExtension());
          $image = Image::make(storage_path().'/photos/imagesprofile/'.$photoname.'.'.$file->guessClientExtension())->resize(140, 140)->save();
          $teacher->profile_image = '/photos/imagesprofile/' . $photoname.'.'.$file->guessClientExtension();
      }
      else
        $teacher->profile_image = null;

      $teacher->save();

      return Redirect::to('add_teacher')->with('message', 'Teacher successfully registered!');
  }

}
