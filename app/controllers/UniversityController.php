<?php

use Helpers\CropImage\CropImage;

class UniversityController extends BaseController
{
	/**
	 * Show university home
	 * 
	 * @return View
	 */
	public function showHome()
	{
		return View::make('university.home')->with(
			array( 
				'subjects' => SubjectController::getSubjects(),
			  	'teachers' => TeacherController::getTeachers(),
			)
		);
	}
	/**
	 * Update the data for the University
	 * 
	 * @return View
	 */
	public function update()
	{
		$flag = false;
		$university = University::find(Auth::id());
		$university->name = ucfirst(trim(Input::get('university_name')));
		$email = trim(strtolower(Input::get('university_email')));

		if(strlen(Input::get('current_password')) > 0) 
		{
			if(!Hash::check(Input::get('current_password'), Auth::user()->password))		
			{	
				return Redirect::back()->withErrors(
					array( 
						'error' => Lang::get('register_university.error_password')
					)
				);
			}
			else
				Auth::user()->password = Hash::make(Input::get('new_password'));		
		}

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
		else if(strlen(Input::get('current_password')) > 0)
			Auth::user()->save();

		$university->acronym = strtoupper(trim(Input::get('university_acronym')));
		
		if(Input::hasFile('avatar_file'))
		{
			$data = Input::get('avatar_data');

			if(is_null($university->profile_image))
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

	/**
	 * Show view university profile
	 * 
	 * @return View
	 */
	public function showProfile()
	{
		return View::make('university.profile')->with(
			array(
				'university' => University::find(Auth::id()),
			)
		);
	}

	/**
	 * Register University
	 * 
	 * @return View
	 */
	public function registerUniversity()
	{
		if (!is_null(Input::get('g-recaptcha-response')))
		{
			$recaptcha = new \ReCaptcha\ReCaptcha(Config::get('recaptcha.private_key'));
			
			$resp = $recaptcha->verify(
				Input::get('g-recaptcha-response'), 
				Request::server('REMOTE_ADDR')
			);

			if ($resp->isSuccess()) 
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
					return Redirect::back()->withErrors(
						array( 
							'error' => Lang::get('register_university.email_duplicated')
						)
					);
				}

				$user = User::first(['user' => $user->user]);

				$university = new University;
				$university->_id = $user->_id;
				$university->name = trim(Input::get('university_name'));
				$university->email = trim(strtolower(Input::get('university_email')));
				$university->acronym = strtoupper(trim(Input::get('university_acronym')));
				$university->profile_image = null;
				$university->save();

				return Redirect::to('/')->with('message', Lang::get('register_university.register_true'));
			} 
			else 
			{
			    $errors = $resp->getErrorCodes();

			    return Redirect::back()->withErrors(
						array( 
							'error' => Lang::get('register_student.message_captcha').' ['.$errors[0].']'
						)
					);
			}
		}
		else
		{
			return Redirect::back()->withErrors(
						array( 
							'error' => Lang::get('register_student.message_captcha').' [ 99 ]'
						)
					);
		}
	}
}