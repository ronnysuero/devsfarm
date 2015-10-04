<?php

class UserController extends BaseController
{
	/**
	* Verify the user's data for login
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

		$user = BlockedUser::where('user', $userdata['user'])->first();

		if(isset($user->_id))
		{	
			$datebegin = new DateTime(date('Y-m-d H:i', $user->date->sec));
			$datebegin = $datebegin->diff(new DateTime());

			$minutes = $datebegin->days * 24 * 60;
			$minutes += $datebegin->h * 60;
			$minutes += $datebegin->i;

			if($minutes > 30)
				$user->delete();
			else
				return Redirect::back()->withErrors(
							array( 
								'error' =>  Lang::get('login.attemp').' ['.$user->user.'] '.
											Lang::get('login.blocked').(30-$minutes).
											Lang::get('login.minute')
								)
						);
		}

		//checks if the user wants to be remembered
		$isAuth = (Input::get('check_user') === 'yes') ? Auth::attempt($userdata, true) : Auth::attempt($userdata);

		// Try to authenticate the credentials
		if($isAuth)
		{
			if(Session::has($userdata['user']))
				Session::forget($userdata['user']);
		
			return Redirect::to(Lang::get('routes.'.Auth::user()->rank));
		}
		else
			return $this->validateUser($userdata['user']);
	}

	/**
	 * Validates that no more than 3 failed attempts login to the user sent as a parameter
	 * 
	 * @param  String $email
	 * @return View 
	 */
	public static function validateUser($email)
	{
		$count = User::where(['user' => $email])->count();
		
		if($count > 0)
		{
			if(Session::has($email))
			{
				$value = Session::get($email);

				if($value >= 2)
				{
					$user = new BlockedUser;
					$user->user = $email;
					$user->date = new MongoDate;
					
					try
					{
						$user->save();
					}
					catch(MongoDuplicateKeyException $e) { }
					
					$user = User::first(['user' => $email]);
					$info = UserController::getUser($user);

					$data = array(
						'name' => strtoupper($info->name)	
					);

					Mail::send('emails.block-user', $data, function($message) use($email)
					{	
						$message->to($email)->subject(Lang::get('login.blocked_title'));
					});

					return Redirect::back()->withErrors(
						array( 
							'error' =>  Lang::get('login.attemp').' ['.$email.'] '.
										Lang::get('login.blocked').(30).
										Lang::get('login.minute')
						)
					);
				}
				else
				{
					$value += 1;
					Session::put($email, $value);
				}
			}
			else
				Session::put($email, 1);
		}
		
		return Redirect::back()->withErrors(array( 'error' => Lang::get('login.invalid_user')));
	}

	/**
	* Logout User
	*
	* @return View
	*/
	public function logout()
	{
		$this->updateLastActivity();
		Auth::logout();
		return Redirect::to('/');
	}

	/**
	 * Check if the user is logged for show their respective home or login screen
	 * 
	 * @return View
	 */
    public function showWelcomeView()
    {
        // Check if the user is reminded in the system
        if (Auth::check())
            return Auth::viaRemember() ? Redirect::to(Lang::get('routes.'.Auth::user()->rank))->with('rememberMe', 1) : Redirect::to(Lang::get('routes.'.Auth::user()->rank));
        else
            return View::make('login.welcome');
    }

	/**
	 * Update the User data for stored the last activity
	 * 
	 * @return void
	 */
	public static function updateLastActivity()
	{
		if (!Auth::guest())
		{
			Auth::user()->last_activity = new MongoDate;
			Auth::user()->save();
		}
	}

	/**
	 * Returns the collection to which the user belongs
	 * 
	 * @param  $user User
	 * @return Object
	 */
	public static function getUser($user)
	{

		if(strcmp($user->rank, 'university') === 0)
			return University::find($user->_id);
		else if (strcmp($user->rank, 'teacher') === 0) 
			return Teacher::find($user->_id);
		else if (strcmp($user->rank, 'student') === 0) 
			return Student::find($user->_id);
		else
			return null;
	}

	/**
	 * Return view forget password
	 * 
	 * @return View
	 */
	public function showForgetPasswordView()
	{
		return View::make('login.forget-password');
	}

	/**
	 * Show view reset password 
	 * 
	 * @return View
	 */
	public function showResetPasswordView()
	{
		$user = Session::get('user');
		
		return is_null($user) ? Redirect::to('/') : View::make('login.reset-password')->with('user', $user);
	}

	/**
	 * Generate a token and sends it by mail to the user to retrieve your password
	 * 
	 * @return View
	 */
	public function forgetPassword()
	{
		$email = strtolower(trim(Input::get('email')));
		
		$user = User::first(['user' => $email]);

		if(!isset($user->user))
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

	/**
	 * Verifies that the token is stored in a Student collection
	 * 
	 * @param  $token String 
	 * @return View
	 */
	public function confirmToken($token)
	{
		$user = User::first(['password_token' => $token]);

		if(!isset($user->user))
			return Redirect::to(Lang::get('routes.forget_password'))->withErrors(array( 'error' => Lang::get('register_student.link_expired')));

		$datebegin = new DateTime(date('Y-m-d H:i', $user->date_password_token->sec));
		$datebegin = $datebegin->diff(new DateTime());

		$user->password_token = null;
		$user->date_password_token = null;
		$user->save();

		$minutes = $datebegin->days * 24 * 60;
		$minutes += $datebegin->h * 60;
		$minutes += $datebegin->i;

		if($minutes > 60)
			return Redirect::to(Lang::get('routes.forget_password'))->withErrors(array( 'error' => Lang::get('register_student.link_expired')));
		else
			return Redirect::to(Lang::get('routes.reset_password'))->with('user', $user);
	}

	/**
	 * Reset password for the student
	 * 
	 * @return View
	 */
	public function resetPassword()
	{
		$user = User::first(['_id' => trim(Input::get('_id'))]);
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		$info = UserController::getUser($user);

		$data = array(
			'name' => strtoupper($info->name)	
		);

		Mail::send('emails.confirm-reset-password', $data, function($message)
		{
			$message->to(strtolower(trim(Input::get('email'))))->subject(Lang::get('forget-password.reset_succes'));
		});		

		$user = BlockedUser::where('user', $user->user)->first();

		if(isset($user->_id))
		{
			$user->delete();
			
			if(Session::has($user->user))
				Session::forget($user->user);
		}

		return Redirect::to('/')->with('message', Lang::get('register_student.password_changed'));
	}

	/**
	 * Generate an email valid for the teacher 
	 *  
	 * @return String
	 */
	public function generateUser()
	{
		if(Request::ajax())
		{
			$email = strtolower(Input::get('email'));
			$domain = substr(Auth::user()->user, strpos(Auth::user()->user, '@'));
			$user = User::find(['user' => $email.$domain]);

			if(isset($user->user))
			{
				$seed = 01;
			
				while(isset($user->user))
				{
					$user = User::find(['user' => $email.$seed.$domain]);

					if(!isset($user->user))
					{
						if($seed < 10)
							$email .= ('0'.$seed);
						else
							$email .= $seed;
					}
					else
						$seed++;
				}
			}

			return Response::json($email.$domain);
		}
	}
}
