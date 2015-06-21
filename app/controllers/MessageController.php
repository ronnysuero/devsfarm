<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 15/06/15
 * Time: 21:28
 */

class MessageController extends BaseController
{

    public function showAllMessagesView ()
    {
        return View::make('message.show_all_messages');
    }

    public function showSendMessageView ()
    {
//        if(Auth::user()->rank ===  "university")
//        {
//            return View::make('message.send_message')->with(array('master' => 'university.master'));
//
//        } elseif (Auth::user()->rank == "teacher")
//        {
//            return View::make('message.send_message')->with(array('master' => 'teacher.master'));
//        } elseif (Auth::user()->rank == "student")
//        {
//            return View::make('message.send_message')->with(array('master' => 'student.master'));
//        }
        return View::make('message.send_message');
    }

    public function showMessageView ()
    {
        return View::make('message.show_message');
    }
}