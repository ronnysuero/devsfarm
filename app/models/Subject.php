<?php

class Subject extends Moloquent
{
  protected $collection = "Subject";

  public function sections()
  {
    return $this->embedsMany('Section');
  }
}
