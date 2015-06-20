<?php

class UniversityController extends BaseController
{

  public function showHome()
  {
      return View::make('university.home')->with(array( 'subjects' => SubjectController::getSubjects(),
                                                          'teachers' => TeacherController::getTeachers()));
  }

  public function showProfile()
  {
//        $university = University::where('email', "=", Auth::id())->get();
      return View::make('university.profile');
  }

	public function registerUniversity()
	{
		$user = new User;
		$user->user = Input::get('university_email');
		$user->password = Hash::make(Input::get('university_password'));
		$user->rank = "university";

		try
		{
			$user->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(array( 'error' => 'This email is already registered in our system'));
		}

    $user = User::first(['user' => $user->user]);

		$university = new University;
		$university->_id = $user->_id;
		$university->name = Input::get('university_name');
		$university->email = Input::get('university_email');
		$university->acronym = Input::get('university_acronym');
		$university->save();

		return Redirect::to('/')->with('message', 'Thank you for registering');
	}

	public function showRegisterUniversityView()
	{
		return View::make('university.register');
	}

}
