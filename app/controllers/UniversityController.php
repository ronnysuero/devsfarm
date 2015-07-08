<?php

class UniversityController extends BaseController
{
	public function showHome()
	{
		return View::make('university.home')->with(array( 'subjects' => SubjectController::getSubjects(),
			'teachers' => TeacherController::getTeachers()));
	}

	public function update()
	{
		require(app_path().'/helpers/CropImage.php');

		$flag = false;
		$university = University::find(Auth::id());
		$university->name = ucfirst(trim(Input::get('university_name')));
		$email = trim(strtolower(Input::get('university_email')));

		if(strcmp($email, $university->email) !== 0)
		{
			Auth::user()->last_activity = new MongoDate;
			Auth::user()->user = $email;

			try
			{
				Auth::user()->save();
			}
			catch(MongoDuplicateKeyException $e)
			{
				return Redirect::back()->withErrors(array( 'error' => Lang::get('register_university.email_duplicated')));
			}

			$flag = true;
			$university->email = $email;
		}

		$university->acronym = strtoupper(trim(Input::get('university_acronym')));

		if(Input::hasFile('avatar_file'))
		{
			$data = Input::get('avatar_data');

			if($university->profile_image === null)
			{
				$image = new CropImage(null, $data, $_FILES['avatar_file']);
				$university->profile_image = $image->getURL();
			}
			else
				new CropImage($university->profile_image, $data, $_FILES['avatar_file']);
		}

		$university->save();

		if($flag)
		{
			Auth::logout();
			return Redirect::to('/')->with('message', Lang::get('university_profile.relogin'));
		}
		else
			return Redirect::to(Lang::get('routes.university_profile'))->with('message', Lang::get('university_profile.update_message'));
	}

	public function showProfile()
	{
		return View::make('university.profile')->with(array('university' => University::where('_id', '=', Auth::id())->first()));
	}

	public function registerUniversity()
	{
		$user = new User;
		$user->user = trim(strtolower(Input::get('university_email')));
		$user->password = Hash::make(Input::get('university_password'));
		$user->rank = "university";
		$user->last_activity = null;

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
		$university->name = trim(Input::get('university_name'));
		$university->email = trim(strtolower(Input::get('university_email')));
		$university->acronym = strtoupper(trim(Input::get('university_acronym')));
		$university->profile_image = null;
		$university->messages_id = array();
		$university->save();

		return Redirect::to('/')->with('message', Lang::get('register_university.register_true'));
	}

	public function showRegisterUniversityView()
	{
		return View::make('university.register');
	}
}
