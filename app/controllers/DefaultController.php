<?php

class DefaultController extends BaseController {

	public function showWelcome()
	{
		return View::make('default');
	}

}
