<?php

class HomeController extends BaseController
{
	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showView()
	{
		return View::make('home');
	}
}
