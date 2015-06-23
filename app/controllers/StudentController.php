<?php

class StudentController extends BaseController
{
	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showHome()
	{
		return View::make('student.home');
	}

	/**
	 * Show the view on the navigator
	 *
	 * @return void
	 */
	public function showRegisterView()
	{
		return View::make('student.register');
	}

	public function registerStudent()
	{
		$user = new User;
		$user->user = strtolower(Input::get('guest_email'));
		$user->password = Hash::make(Input::get('guest_password'));
		$user->rank = "student";
		$user->last_activity = null;

		try
		{
			$user->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(array( 'error' => Lang::get('register_student.email_duplicated')));
		}

		$user = User::first(['user' => $user->user]);

		$student = new Student;
		$student->_id = $user->_id;
		$student->name = Input::get('guest_name');
		$student->last_name = Input::get('guest_lastname');
		$student->id_number = Input::get('guest_id');
		$student->email = strtolower(Input::get('guest_email'));
		$student->genre = Input::get('guest_genre');
		$student->has_a_job = input::get('guest_job');
		$student->is_teamleader = false;
		$student->save();

		return Redirect::to('/')->with('message', Lang::get('register_student.register_true'));
	}
}
