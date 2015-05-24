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
    {
      UserSessionController::update();
      return Redirect::to('home');
    }
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
    UserSessionController::update();
    return Redirect::to('/');
  }

  /**
  * Show the view on the navigator
  *
  * @return void
  */
  public function showView()
  {
    return View::make('register');
  }

	public function register()
	{
      $user = new User;
      $user->first_name = Input::get('guest_name');
      $user->last_name = Input::get('guest_lastname');
      $user->user = Input::get('guest_email');
      $user->genre = Input::get('guest_genre');
      $user->has_a_job = input::get('guest_job');
      $user->birthday = new MongoDate(strtotime(Input::get('user_birthday')));
      $user->password = Hash::make(Input::get('user_password'));

      try
      {
        $user->save();
      }
      catch(MongoDuplicateKeyException $e)
      {
        return Redirect::back()->withErrors(array( 'error' => 'This email is already registered in our system'));
      }

      return Redirect::to('/')->with('message', 'Thank you for registering');
	}
}
