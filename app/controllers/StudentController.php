<?php

class StudentController extends BaseController
{
	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showHome()
	{
		return View::make('student.home');
	}
}
