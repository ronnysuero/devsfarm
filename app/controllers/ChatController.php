<?php

class ChatController extends BaseController
{
	public function showView()
	{
		$users = null;
		$user = null;

		if(strcmp(Auth::user()->rank, 'university') === 0)
		{
			$users = University::where('_id', '!=', Auth::id())->get();
			$user = University::find(Auth::id());
		}
		elseif (strcmp(Auth::user()->rank, 'teacher') === 0) 
		{
			$users = Teacher::where('_id', '!=', Auth::id())->get();
			$user = Teacher::find(Auth::id());
		}
		elseif (strcmp(Auth::user()->rank, 'student') === 0)
		{
			$users = Student::where('_id', '!=', Auth::id())->get();
			$user = Student::find(Auth::id());
		} 

		if($users !== null)
			return View::make('chat.home')->with(array('contacts' => $users, 'user' => $user));
	}

	public function find()
	{
		if(Request::ajax())
		{
			$array = array(
				Input::get('_id'),
				Input::get('receiver')
				);

			$chat = Chat::whereIn('participants', $array)->first();

			if($chat !== null)
				return Response::json(array('id' => $chat->_id));
			else 
				return Response::json(array('id' => ""));			
		}
	}
}