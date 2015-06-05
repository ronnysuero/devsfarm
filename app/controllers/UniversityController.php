<?php

class UniversityController extends BaseController
{
    public function showHome()
    {
      return View::make('university.home')->with(array( 'subjects' => 'Invalid Email or Password',
                                                                      'professors' => 'Mundo'));
    }

    public function showProfile()
    {
      return View::make('university.profile');
    }

    public function addSubject()
    {

      $university = University::where('email', '=', Auth::user()->user)->first();

      $subject = new Subject;
      $subject->name = Input::get('subject_name');
      $subject->university_id = Auth::id();
      $subject->division = Input::get('division');
      $sections = explode(',', Input::get('section'));
      $trimList = array();

      foreach($sections as $section)
      {
        array_push($trimList, trim($section));
      }

      $subject->sections = $trimList;
      $subject->save();

      return Redirect::to('add_subject')->with('message', 'Subject successfully registered!');
    }

    public function showAddSubjectView()
    {
        return View::make('university.add_subject');
    }
}
