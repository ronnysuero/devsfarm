<?php

class ChatController extends BaseController
{
	/**
	 * Show chat home view
	 * 
	 * @return View
	 */
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
		
		$ip = (App::isLocal()) ? '127.0.0.1' : '104.131.3.39';
		return View::make('chat.home')->with(array('contacts' => $users, 'user' => $user, 'ip'=> $ip));
	}

	/**
	 * Find all conversations between 2 users
	 * 
	 * @return JSON Ajax
	 */
	public function find()
	{
		if(Request::ajax())
		{
			$array = array(
				Auth::id(),
				new MongoId(Input::get('receiver_id'))
				);

			$chat = Chat::where('participants', 'all', $array)->first();

			if(!isset($chat->_id))
			{
				$user_sender = User::first(Auth::id());
				$user_receiver = User::first(Input::get('receiver_id'));
				$sender = UserController::getUser($user_sender);		
				$receiver = UserController::getUser($user_receiver);
				$sender_name = "";
				$receiver_name = "";	

				if(strcmp($user_sender->rank, 'university') === 0)
					$sender_name = $sender->acronym;
				else
					$sender_name = $sender->name.' '.$sender->last_name;

				if(strcmp($user_receiver->rank, 'university') === 0)
					$receiver_name = $receiver->acronym;
				else
					$receiver_name = $receiver->name.' '.$receiver->last_name;

				return Response::json(array('chat' => $chat, 
					'sender' => array('_id' => $sender->_id, 'name' => $sender_name), 
					'receiver' => array('_id' => $receiver->_id, 'name' => $receiver_name)
					)
				);
			}
			else 
				return Response::json(array('chat' => ""));			
		}
	}
}