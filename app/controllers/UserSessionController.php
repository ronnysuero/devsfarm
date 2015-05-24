<?php

class UserSessionController extends BaseController
{
  public static function update()
  {
    $user = User::find(['user' => Input::get('user_email')]);
    $session = UserSession::where('user_id', '=', $user->_id)->get();

    if ($session instanceOf UserSession)
    {
      $session->last_activity = new MongoDate;
      $session->save();
    }
    else
    {
      $session = new UserSession;
      $session->user_id = $user->_id;
      $session->last_activity = new MongoDate;
      $session->save();
    }
  }
}
