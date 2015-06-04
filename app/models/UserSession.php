<?php

use Jenssegers\Mongodb\Model as Eloquent;

class UserSession extends Moloquent
{
  protected $collection = "users_sessions";
}
