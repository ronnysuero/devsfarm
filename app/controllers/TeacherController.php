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

    return Redirect::to(Lang::get('routes.add_teacher'))->with('message', Lang::get('register_teacher.success'));
  }

  public function update()
  {
    $teacher = Teacher::where('_id', '=', new MongoId(Input::get('_id')))->first();

    $email = strtolower(Input::get('email'));

    if(strcmp($email, $teacher->email) !== 0)
    {
      Auth::user()->user = $email;
      Auth::user()->save();
  
      $teacher->email = $email;
    }

    $teacher->name = Input::get('name');
    $teacher->last_name = Input::get('last_name');
    $teacher->phone = Input::get('phone');
    $teacher->cellphone = Input::get('cellphone');

    if (Input::hasFile('photo'))
    {
        if($teacher->profile_image == null)
        {
          $file = Input::file('photo');
          $photoname = uniqid();
          $file->move(storage_path() . '/photos/imagesprofile', $photoname.'.'.$file->guessClientExtension());
          $image = Image::make(storage_path().'/photos/imagesprofile/'.$photoname.'.'.$file->guessClientExtension())->resize(140, 140)->save();
          $teacher->profile_image = '/photos/imagesprofile/' . $photoname.'.'.$file->guessClientExtension();
        }
        else
        {
          $file = Input::file('photo')->getRealPath();
          $image = Image::make($file)->resize(140, 140)->save(storage_path().$teacher->profile_image);
        }        
    }
    
    $teacher->save();

    return Redirect::to(Lang::get('routes.show_all_teachers'))->with('message', Lang::get('university_profile.update_message'));  
  }

  public function find()
  {
    if(Request::ajax())
    {
      $teacher = Teacher::where('email', '=', Input::get('email'))->first();
      return Response::json($teacher);
    }
  }
}
