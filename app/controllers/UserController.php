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
        'user' => Input::get('user_email'),
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
  		return View::make('login');
  }

  public function updateLastActivity()
  {
    Auth::user()->last_activity = new MongoDate;
    Auth::user()->save();
  }
}
