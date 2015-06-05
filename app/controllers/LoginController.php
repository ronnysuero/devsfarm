<?php

class LoginController extends BaseController
{
	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showView()
	{
		// Check if the user is reminded in the system
		if (Auth::check())
			return Auth::viaRemember() ? Redirect::to('home')->with('rememberMe', 1) : Redirect::to(Auth::user()->rank);
		else
			return View::make('login');
	}
}
