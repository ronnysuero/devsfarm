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
        return View::make('university.show_all_messages');
    }

    public function showSendMessageView ()
    {
        return View::make('university.send_message');
    }

    public function showMessageView ()
    {
        return View::make('university.show_message');
    }
}