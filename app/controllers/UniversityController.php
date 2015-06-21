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
			return Redirect::back()->withErrors(array( 'error' => Lang::get('register_university.email_duplicated')));
		}

    $user = User::first(['user' => $user->user]);

		$university = new University;
		$university->_id = $user->_id;
		$university->name = Input::get('university_name');
		$university->email = Input::get('university_email');
		$university->acronym = Input::get('university_acronym');
		$university->save();

		return Redirect::to('/')->with('message', Lang::get('register_university.register_true'));
	}

	public function showRegisterUniversityView()
	{
		return View::make('university.register');
	}

}
