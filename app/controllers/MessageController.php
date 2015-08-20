<?php

class MessageController extends BaseController
{
	/**
	 * Show view Inbox
	 * 
	 * @return View
	 */
	public function showInboxView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('from', '!=', Auth::id())
   									 ->where('archived', false)
									 ->orderBy('sent_date', 'desc')->get();

		return View::make('message.inbox')->with(
			array(	
				'messages' => $messages, 
				'stats' => $this->getStats(),
				'unreadMessages' => $this->unReadMessages()
			)
		);
	}

	/**
	 * Show view message sent
	 * 
	 * @return View
	 */
	public function showMessageSentView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('from', Auth::id())
									 ->where('archived', false)
									 ->orderBy('sent_date', 'desc')->get();
		
		return View::make('message.sent')->with(
			array(	
				'messages' => $messages, 
				'stats' => $this->getStats(),
				'unreadMessages' => $this->unReadMessages()
			)
		);
	}

	/**
	 * Show view message archived
	 * 
	 * @return View
	 */
	public function showMessageArchivedView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('archived', true)
									 ->orderBy('sent_date', 'desc')->get();
		
		return View::make('message.archived')->with(
			array(	
				'messages' => $messages, 
				'stats' => $this->getStats(),
				'unreadMessages' => $this->unReadMessages()
			)
		);
	}

	/**
	 * Show view message unread
	 * 
	 * @return View
	 */
	public function showMessageUnreadView()
	{
		return View::make('message.unread')->with(
			array(
				'messages' => $this->unReadMessages("all"), 
				'stats' => $this->getStats(),
				'unreadMessages' => $this->unReadMessages()
			)
		);
	}

	/**
	 * Send a message to one or more users
	 * 
	 * @return JSON Ajax
	 */
	public function sendMessage()
	{
		if(Request::ajax())
		{
			$emails = explode(',', trim(Input::get('receptor')));
			$emailsValidate = array();        
			$users = array();
			$usersFails = array();

			foreach($emails as $email)
				array_push($emailsValidate, strtolower(trim($email)));
			
			$emails = array();

			foreach ($emailsValidate as $email) 
			{
				$user = User::first(['user' => $email]);

				if(is_null($user))
					array_push($usersFails, $email);
				else
				{            
					array_push($users, $user);
					array_push($emails, $user->_id); 
				}
			}

			if(count($usersFails) > 0)
				return Response::json(Lang::get('send_message.error_mail').': ['.implode(', ', $usersFails).']');

			$message = new Message;
			$message->_id = new MongoId;
			$message->from = Auth::id();
			$message->to = $emails;
			$message->subject = trim(Input::get('subject'));
			$message->body = trim(Input::get('content'));
			$message->sent_date = new MongoDate;
			$message->read = false;
			$message->archived = false;

			foreach ($users as $user) 
				UserController::getUser($user)->messages()->associate($message)->save();

			$message->read = true;	
			UserController::getUser(Auth::user())->messages()->associate($message)->save();

			return Response::json('00');
		}		
	}

	/**
	 * Seach the emails of users ids
	 * 
	 * @param  $id Array(MongoId)
	 * @return Array(String)
	 */
	private function searchUsers($id)
	{
		$emails = array();

		foreach ($id as $user_id) 
		{
			$user = User::find($user_id);
			$user_search = null;

			if (strcmp($user->rank, 'university') === 0)
			{
				$user_search = University::find($user->_id);
				$format = $user_search->name.' ('.$user_search->email.')';
				array_push($emails, $format);
			}
			else if (strcmp($user->rank, 'teacher') === 0)
			{
				$user_search = Teacher::find($user->_id);
				$names = explode(' ', $user_search->name);
				$last_names = explode(' ', $user_search->last_name);
				$format = $names[0].' '.$last_names[0].' ('.$user_search->email.')';
				array_push($emails, $format);
			}
			else if (strcmp($user->rank, 'student') === 0)
			{
				$user_search = Student::find($user->_id);
				$format = $user_search->first_name.' '.$user_search->last_name.' ('.$user_search->email.')';
				array_push($emails, $format);   
			} 
		}
		return $emails;
	}

	/**
	 * Find a message
	 * 
	 * @return JSON Ajax
	 */
	public function find()
	{
		if(Request::ajax())
		{
			$user =  UserController::getUser(Auth::user());
			$message = $user->messages()->find(Input::get('_id'));
			
			if($message->read === false)
			{
				$message->read = true;
				$message->save();	
			}
			
			$flag = Input::get('flag');            

			if(!is_null($flag) && $flag === true)
				 $emails = $this->searchUsers(array($message->from));
			 else
				 $emails = $this->searchUsers($message->to);

			return Response::json(
				array(
					'messages' => $message, 
					'emails' => $emails, 
					'stats' => $this->getStats()
				)
			);
		}
	}

	/**
	 * Remove a message from the Message Collection
	 * 
	 * @return JSON Ajax
	 */
	public function drop()
	{
		if(Request::ajax())
		{
			$ids = Input::get('_ids');
			$user = UserController::getUser(Auth::user());

			foreach ($ids as $value) 
				 $user->messages()->find($value)->delete();
			
			return Response::json("00");
		}
	}

	/**
	 * Archived a message
	 * 
	 * @return JSON Ajax
	 */
	public function archived()
	{
		if(Request::ajax())
		{
			$ids = Input::get('_ids');
			$user = UserController::getUser(Auth::user());

			foreach ($ids as $value)
			{
			 	$message = $user->messages()->find($value);

				if($message->archived === false)
			 	{
					$message->archived = true;
					$message->save();					
			 	}
			} 

			return Response::json("00");
		}
	}

	/**
	 * Mark a message as read
	 *  
	 * @return JSON Ajax
	 */
	public function markRead()
	{
		if(Request::ajax())
		{
			$ids = Input::get('_ids');
			$user = UserController::getUser(Auth::user());

			foreach ($ids as $value)
			{
				$message = $user->messages()->find($value);
				
				if($message->read === false)
				{
					$message->read = true;
					$message->save();					
				}
			} 
			
			return Response::json("00");
		}
	}

	/**
	 *	Return the stats message for a User
	 * 
	 * @return Array(Stats)
	 */
	public static function getStats()
	{
		$messages = UserController::getUser(Auth::user())->messages();
		$inbox = $messages->where('from', '!=', Auth::id())->where('archived', false)->count();
		$sent = $messages->where('from', Auth::id())->where('archived', false)->count();
		$archived = $messages->where('archived', true)->count();
		
		return array(
			'inbox' => $inbox,
			'unread' => count(MessageController::unReadMessages("all")),
			'sent' => $sent,
			'archived' => $archived,
			'approve' => PendingEnrollment::where('teacher_id', Auth::id())->count(),
		);	
	}

	/**
	 * Return the unread messages for an User
	 * 
	 * @param  $limit
	 * @return Array(Messages)
	 */
	public static function unReadMessages($limit = null)
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('read', false)
									 ->where('archived', false);
		if(is_null($limit))
			$messages = $messages->take(5);
		
		return $messages->orderBy('sent_date', 'desc')->get();
	}

	/**
	 * Convert the date in a format readable for the user
	 *  
	 * @param  $date Date
	 * @return Date
	 */
	public static function getDate($date)
	{
		$compare = new DateTime(date('Y-m-d H:i:s', $date->sec));
		$compare = $compare->diff(new DateTime());
				
		if($compare->days > 0)
			return date('d-m-Y h:i A', $date->sec);
		else if($compare->h < 24 && $compare->h > 0)
		  	return (App::getLocale() === 'es') ? "Hace ".$compare->h.' horas' : $compare->h." hours ago";
		else if($compare->i < 60 && $compare->i > 0)
		  	return (App::getLocale() === 'es') ? "Hace ".$compare->i.' minutos' : $compare->i." mins ago";
		else if($compare->s < 60 && $compare->s > 0)
		  	return (App::getLocale() === 'es') ? "Hace ".$compare->s.' segundos' : $compare->s." segs ago";
		else 
			return (App::getLocale() === 'es') ? "Hace 1 segundo" : "1 segs ago";
	}

	/**
	 * Checks whether the recipient isn't the same user
	 * 
	 * @param  $id MongoId
	 * @return Boolean
	 */
	public static function searchOrigin($id)
	{
		$message = UserController::getUser(Auth::user())->messages()->find($id);

		if($message->from !== Auth::id())
			return true;
		else
			return null;
	}
}