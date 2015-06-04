<?php

class UserSessionController extends BaseController
{
  public static function update()
  {
    $session = UserSession::where('user_id', '=', Auth::id())->first();

    if(isset($session->user_id))
    {
      if ($session->user_id == Auth::user()->_id)
        $session->last_activity = new MongoDate;
    }
    else
    {
      $session = new UserSession;
      $session->user_id = Auth::user()->_id;
      $session->last_activity = new MongoDate;
    }

    $session->save();
  }
}
