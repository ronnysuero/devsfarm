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

	public function register()
	{

      $user = new User;
      $user->user = Input::get('guest_email');
      $user->password = Hash::make(Input::get('guest_password'));
      $user->rank = "student";

      try
      {
        $user->save();
      }
      catch(MongoDuplicateKeyException $e)
      {
        return Redirect::back()->withErrors(array( 'error' => 'This email is already registered in our system'));
      }

      // $university = new University;
      // $university->name = "Universidad Autonoma De Santo Domingo";
      // $university->email = "uasd@uasd.edu.do";
      // $university->acronym = "UASD";
      // $university->save();

      $student = new Student;
      $student->name = Input::get('guest_name');
      $student->last_name = Input::get('guest_lastname');
      $student->email = Input::get('guest_email');
      $student->genre = Input::get('guest_genre');
      $student->has_a_job = input::get('guest_job');
      $student->birthday = new MongoDate(strtotime(Input::get('guest_birthday')));
      $student->is_teamleader = false;
      $student->save();

      return Redirect::to('/')->with('message', 'Thank you for registering');
	}
}
