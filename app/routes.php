<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	if (Auth::check())
		return Auth::viaRemember() ? Redirect::to('home')->with('rememberMe', 1) : Redirect::to('home');
	else
		return View::make('default');
});

Route::get('register', function()
{
	return View::make('register');
});

Route::get('home', array('before' => 'auth', function()
{
	return View::make('home');
}));

Route::post('login', function()
{
    // Get the login form data using the 'Input' class
    $userdata = array(
        'user' => Input::get('user_email'),
        'password' => Input::get('user_password')
    );

		$isAuth = (Input::get('check_user') === 'yes') ? Auth::attempt($userdata, true) : Auth::attempt($userdata);

		// Try to authenticate the credentials
		if($isAuth)
			return Redirect::to('home');
		else
			return Redirect::back()->withErrors(array( 'error' => 'Invalid Email or Password'));
});

Route::get('logout', function()
{
    Auth::logout();
    return Redirect::to('/');
});
