<?php

class University extends Moloquent
{
    protected $collection = "University";

    public function subjects()
    {
      return $this->hasMany('Subject');
    }
}
