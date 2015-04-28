<?php

class GradesController extends  BaseController
{
  public function showGrades()
  {
    $grades = Grades::all();

    return View::make('grades.list', array('grades'=>$grades));
  }
}
