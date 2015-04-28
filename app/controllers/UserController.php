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
    if($isAuth)
      return Redirect::to('home');
    else
      return Redirect::back()->withErrors(array( 'error' => 'Invalid Email or Password'));
  }

  /**
	* Removes user login cookie
	*
	* @return void
	*/
  public function logout()
  {
    Auth::logout();
    return Redirect::to('/');
  }
}
