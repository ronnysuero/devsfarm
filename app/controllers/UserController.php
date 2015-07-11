<?php

class UserController extends BaseController
{
	/**
	* Verify the user's data
	*
	* @return void
	*/
	public function login()
	{
		// Get the login form data using the 'Input' class
		$userdata = array(
			'user' => strtolower(Input::get('user_email')),
			'password' => Input::get('user_password')
			);

		//checks if the user wants to be remembered
		$isAuth = (Input::get('check_user') === 'yes') ? Auth::attempt($userdata, true) : Auth::attempt($userdata);

		// Try to authenticate the credentials
		return $isAuth ? Redirect::to(Lang::get('routes.'.Auth::user()->rank)) : Redirect::back()->withErrors(array( 'error' => Lang::get('login.invalid_user')));
	}

	/**
	* Removes user login token
	*
	* @return void
	*/
	public function logout()
	{
		$this->updateLastActivity();
		Auth::logout();
		return Redirect::to('/');
	}

	public function showView()
	{
		// Check if the user is reminded in the system
		if (Auth::check())
			return Auth::viaRemember() ? Redirect::to(Lang::get('routes.'.Auth::user()->rank))->with('rememberMe', 1) : Redirect::to(Lang::get('routes.'.Auth::user()->rank));
		else
			return View::make('login.login');
	}

	public function showRegisterView()
	{
		return View::make('login.register');
	}

	public function updateLastActivity()
	{
		Auth::user()->last_activity = new MongoDate;
		Auth::user()->save();
	}

	public static function getUser($user)
	{
		if(strcmp($user->rank, 'university') === 0)
			return University::find(new MongoId($user->_id));
		elseif (strcmp($user->rank, 'teacher') === 0) 
			return Teacher::find(new MongoId($user->_id));
		elseif (strcmp($user->rank, 'student') === 0) 
			return Student::find(new MongoId($user->_id));
		return null;
	}

	public function showForgetPasswordView()
	{
		return View::make('login.forget-password');
	}

	public function forgetPassword()
	{
		$email = strtolower(trim(Input::get('email')));
		
		$user = User::first(['user' => $email]);

		if($user === null)
			return Redirect::back()->withErrors(array( 'error' => Lang::get('register_student.email_not_found')));

		$token = "";

		for( $code_length = 25, $token = ''; strlen($token) < $code_length; 
			$token .= chr(!rand(0, 2) ? rand(48, 57) : (!rand(0, 1) ? rand(65, 90) : rand(97, 122)))
		)
		
		$token .= uniqid();
		$user->password_token = $token;
		$user->date_password_token = new MongoDate;
		$user->save();
		
		$info = UserController::getUser($user);

		$data = array(
			'url'	=> URL::to('/').'/'.Lang::get('routes.forget_password').'/'.$token,
			'name' => strtoupper($info->name)	
		);

		Mail::send('emails.reset-password-mail', $data, function($message)
		{
			$message->to(strtolower(trim(Input::get('email'))))->subject(Lang::get('forget-password.reset'));
		});		
		
		return Redirect::to('/')->with('message', Lang::get('register_student.success_forget_password'));
	}

	public function confirmToken($token)
	{
		$user = User::first(['password_token' => $token]);

		if($user === null)
			return Redirect::to(Lang::get('routes.forget_password'))->withErrors(array( 'error' => Lang::get('register_student.link_expired')));

		$datebegin = new DateTime(date('Y-m-d H:i', $user->date_password_token->sec));
		
		if($datebegin->diff(new DateTime())->i > 60)
			return Redirect::to(Lang::get('routes.forget_password'))->withErrors(array( 'error' => Lang::get('register_student.link_expired')));
		else
		{
			$user->password_token = null;
			$user->date_token_password = null;
			$user->save();

			return Redirect::to(Lang::get('routes.reset_password'))->with('user', $user);
		}
	}

	public function showResetPasswordView()
	{
		$user = Session::get('user');

		return ($user === null) ? Redirect::to('/') : View::make('reset-password')->with('user', $user);
	}

	public function resetPassword()
	{
		$user = User::first(['_id' => trim(Input::get('_id'))]);
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		$info = UserController::getUser($user);

		$data = array(
			'name' => strtoupper($info->name)	
		);

		Mail::send('emails.confirm-reset-password.blade', $data, function($message)
		{
			$message->to(strtolower(trim(Input::get('email'))))->subject(Lang::get('forget-password.reset_succes'));
		});		

		return Redirect::to('/')->with('message', Lang::get('register_student.password_changed'));
	}
}
