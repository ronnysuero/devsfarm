<?php

class Teacher extends Moloquent
{
  protected $collection = "Teacher";

  public function university()
  {
    return $this->hasOne('University');
  }

  public function sections()
  {
    return $this->hasMany('Section');
  }
}
