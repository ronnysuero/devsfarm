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
    return $isAuth ? Redirect::to(Auth::user()->rank) : Redirect::back()->withErrors(array( 'error' => 'Invalid Email or Password'));

  }

  /**
	* Removes user login cookie
	*
	* @return void
	*/
  public function logout()
  {
    UserSectionController::update();
    Auth::logout();
    return Redirect::to('/');
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

    public function showRegisterUniversityView()
    {
        return View::make('university.register_university');
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

       $university = new University;
       $university->name = Input::get('university_name');
       $university->email = Input::get('university_email');
       $university->acronym = Input::get('university_acronym');
       $university->save();

      return Redirect::to('/')->with('message', 'Thank you for registering');
	}
}
