<?php

class UserSectionController extends BaseController
{
  public static function update()
  {
    $session = UserSection::where('user_id', '=', Auth::id())->first();

    if(isset($session->user_id))
    {
        $session->last_activity = new MongoDate;
    }
    else
    {
      $session = new UserSection;
      $session->user_id = Auth::id();
      $session->last_activity = new MongoDate;
    }

    $session->save();
  }
}
