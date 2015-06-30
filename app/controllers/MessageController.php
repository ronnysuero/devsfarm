<?php

class MessageController extends BaseController
{

    public function showAllMessagesView ()
    {
        $user = null;

        if(strcmp(Auth::user()->rank, 'university') === 0)
            $user = University::find(Auth::id());
        elseif (strcmp(Auth::user()->rank, 'teacher') === 0) 
            $user = Teacher::find(Auth::id());
        elseif (strcmp(Auth::user()->rank, 'student') === 0) 
            $user = Student::find(Auth::id());

        if($user !== null)
        {
            $messages = Message::whereIn('_id', $user->messages_id)->whereIn('to', array(Auth::id()))->orderBy('sent_date', 'desc')->get();
            return View::make('message.show_all_messages_received')->with(array('messages' => $messages));
        }
    }

    public function showSendMessageView ()
    {
        return View::make('message.send_message');
    }

    public function showMessageSentView()
    {
        $user = null;

        if(strcmp(Auth::user()->rank, 'university') === 0)
            $user = University::find(Auth::id());
        elseif (strcmp(Auth::user()->rank, 'teacher') === 0) 
            $user = Teacher::find(Auth::id());
        elseif (strcmp(Auth::user()->rank, 'student') === 0) 
            $user = Student::find(Auth::id());

        if($user !== null)
        {
            $messages = Message::whereIn('_id', $user->messages_id)->where('from', '=', Auth::id())->orderBy('sent_date', 'desc')->get();
            return View::make('message.show_all_messages_sent')->with(array('messages' => $messages));
        }
    }

    public function sendMessage()
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

            if($user === null)
                array_push($usersFails, $email);
            else
            {            
                array_push($users, $user);
                array_push($emails, $user->_id); 
            }
        }

        if(count($usersFails) > 0)
            return Redirect::back()->withErrors(array( 'error' => Lang::get('send_message.error_mail').': ['.implode(', ', $usersFails).']'));

        $_id = new MongoId();

        $message = new Message;
        $message->_id = $_id;
        $message->from = Auth::id();
        $message->to = $emails;
        $message->subject = trim(Input::get('subject'));
        $message->body = trim(Input::get('content'));
        $message->sent_date = new MongoDate; 
        $message->save();

        foreach ($users as $user) 
        {
            if (strcmp($user->rank, 'university') === 0)
                University::find($user->_id)->push('messages_id', $_id, true);
            elseif (strcmp($user->rank, 'teacher') === 0) 
                Teacher::find($user->_id)->push('messages_id', $_id, true);
            elseif (strcmp($user->rank, 'student') === 0) 
                Student::find($user->_id)->push('messages_id', $_id, true);
        }

        if (strcmp(Auth::user()->rank, 'university') === 0)
            University::find(Auth::id())->push('messages_id', $_id, true);
        elseif (strcmp(Auth::user()->rank, 'teacher') === 0) 
            Teacher::find(Auth::id())->push('messages_id', $_id, true);
        elseif (strcmp(Auth::user()->rank, 'student') === 0) 
            Student::find(Auth::id())->push('messages_id', $_id, true);
        
        return Redirect::to(Lang::get('routes.send_message'))->with('message', Lang::get('send_message.success')); 
    }

    public static function searchUsers($messages)
    {
        $emails = array();

        foreach ($messages as $user_id) 
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
            $message = Message::find(Input::get('_id'));
            $flag = Input::get('flag');

            if($flag !== null)
                $emails = MessageController::searchUsers($message->from);
            else
                $emails = MessageController::searchUsers($message->to);

            return Response::json(array('messages' => $message, 'emails' => $emails));
        }
    }

    public function drop()
    {
        if(Request::ajax())
        {
            $ids = Input::get('_ids');

            $user = null;

            if (strcmp(Auth::user()->rank, 'university') === 0)
                $user = University::find(Auth::id());
            elseif (strcmp(Auth::user()->rank, 'teacher') === 0) 
                $user = Teacher::find(Auth::id());
            elseif (strcmp(Auth::user()->rank, 'student') === 0) 
                $user = Student::find(Auth::id());

            foreach ($ids as $value) 
                $user->pull('messages_id', new MongoId($value));
            
            return Response::json("00");
        }
    }
}