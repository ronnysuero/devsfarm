<?php

class RegisterController extends BaseController {

	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showView()
	{
		return View::make('register');
	}
}
