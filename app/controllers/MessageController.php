<?php

class MessageController extends BaseController
{
	public function showInboxView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('from', '!=', Auth::id())
   									 ->where('archived', false)
									 ->orderBy('sent_date', 'desc')->get();

		return View::make('message.inbox')->with(array(	'messages' => $messages, 
														'stats' => $this->getStats(),
														'unreadMessages' => $this->unReadMessages()));
	}

	public function showMessageSentView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('from', Auth::id())
									 ->where('archived', false)
									 ->orderBy('sent_date', 'desc')->get();
		
		return View::make('message.sent')->with(array(	'messages' => $messages, 
														'stats' => $this->getStats(),
														'unreadMessages' => $this->unReadMessages()));
	}

	public function showMessageArchivedView()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('archived', true)
									 ->orderBy('sent_date', 'desc')->get();
		
		return View::make('message.archived')->with(array(	'messages' => $messages, 
															'stats' => $this->getStats(),
															'unreadMessages' => $this->unReadMessages()));
	}

	public function showMessageUnreadView()
	{
		return View::make('message.unread')->with(array('messages' => $this->unReadMessages(), 
														'stats' => $this->getStats(),
														'unreadMessages' => $this->unReadMessages()));
	}

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

			// if(count($usersFails) > 0 && count($users) === 0)
			// 	return Redirect::back()->withErrors(array( 'error' => Lang::get('send_message.error_mail').': ['.implode(', ', $usersFails).']'));

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
		// if(count($usersFails) > 0)
		// 	return Redirect::to(URL::previous())->withErrors(array('error' => Lang::get('send_message.warning').': ['.implode(', ', $usersFails).']'));			

		// return Redirect::to(URL::previous())->with('message', Lang::get('send_message.success')); 
	}

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
			elseif (strcmp($user->rank, 'teacher') === 0)
			{
				$user_search = Teacher::find($user->_id);
				$names = explode(' ', $user_search->name);
				$last_names = explode(' ', $user_search->last_name);
				$format = $names[0].' '.$last_names[0].' ('.$user_search->email.')';
				array_push($emails, $format);
			}
			elseif (strcmp($user->rank, 'student') === 0)
			{
				$user_search = Student::find($user->_id);
				$format = $user_search->first_name.' '.$user_search->last_name.' ('.$user_search->email.')';
				array_push($emails, $format);   
			} 
		}
		return $emails;
	}

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

			return Response::json(array('messages' => $message, 
										'emails' => $emails, 
										'stats' => $this->getStats()));
		}
	}

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

	public static function getStats()
	{
		$messages = UserController::getUser(Auth::user())->messages();
		$inbox = $messages->where('from', '!=', Auth::id())->where('archived', false)->count();
		$sent = $messages->where('from', Auth::id())->where('archived', false)->count();
		$archived = $messages->where('archived', true)->count();
		
		return array(
			'inbox' => $inbox,
			'unread' => count(MessageController::unReadMessages()),
			'sent' => $sent,
			'archived' => $archived
		);	
	}

	public static function unReadMessages()
	{
		$user = UserController::getUser(Auth::user());
		$messages = $user->messages()->where('read', false)
									 ->where('archived', false)
									 ->orderBy('sent_date', 'desc')->get();
		return $messages;
	}

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

	public static function searchOrigin($id)
	{
		$message = UserController::getUser(Auth::user())->messages()->find($id);

		if($message->from !== Auth::id())
			return true;
		else
			return null;
	}
}