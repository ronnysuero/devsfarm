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
		$users = array();
		$user = UserController::getUser(Auth::user());

		if ($user instanceof Teacher)
		{ 
			$sectionCodes = SectionCode::where('teacher_id', new MongoId($user->_id))
									   ->where('status', true)	
									   ->get();
			
			foreach ($sectionCodes as $sectionCode) 
			{
				foreach ($sectionCode->teamleaders_id as $id) 
					array_push($users, Student::find($id));
			
				$users = array_unique($users);
			}
		}
		else if ($user instanceof Student)
		{
			$sectionCodes = SectionCode::whereIn('students_id', array(new MongoId($user->_id)))
									   ->where('status', true)	
									   ->get();
			
			foreach ($sectionCodes as $sectionCode) 
			{
				foreach ($sectionCode->students_id as $id)
				{
					if($id != Auth::id()) 
						array_push($users, Student::find($id));
				}

				$count = SectionCode::whereIn('teamleaders_id', array(Auth::id()))
									->where('_id', new MongoId($sectionCode->_id))
									->count();

				if($count > 0)
					array_push($users, Teacher::find($sectionCode->teacher_id));	

				$users = array_unique($users);
			}
		}
		else if($user instanceof University)
			return View::make('error.403');

		$ip = App::isLocal() ? '127.0.0.1' : '104.131.3.39';
		
		return View::make('chat.home')->with(
			array(
				'contacts' => $users, 
				'user' => $user, 
				'ip'=> $ip
			)
		);
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

			$chat = Chat::whereIn('participants', $array)->first();

			if(isset($chat->_id))
			{
				$sender = UserController::getUser(Auth::user());		
				$receiver = UserController::getUser(User::first(Input::get('receiver_id')));
				$sender_name = $sender->name.' '.$sender->last_name;
				$receiver_name = $receiver->name.' '.$receiver->last_name;

				return Response::json(
					array(
						'chat' => $chat, 
						'sender' => array('_id' => $sender->_id, 'name' => $sender_name), 
						'receiver' => array('_id' => $receiver->_id, 'name' => $receiver_name)
					)
				);
			}
			else 
				return Response::json(array('chat' => ""));		
		}
	}

	public static function getUsersChat($code)
	{
		$user = UserController::getUser(Auth::user());
		$sectionCodes = "";

		if($user instanceof Teacher)
		{
			$sectionCodes = SectionCode::where('teacher_id', new MongoId($user->_id))
									   ->where('status', true)
									   ->where('code', $code)	
									   ->first();
		}
		else if ($user instanceof Student)
		{
			$sectionCodes = SectionCode::whereIn('students_id', array(new MongoId($user->_id)))
									   ->where('status', true)
									   ->where('code', $code)
									   ->first();
		}
		else
			$sectionCodes = null;

		return $sectionCodes;
	}
}