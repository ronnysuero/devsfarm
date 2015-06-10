<?php

class SubjectController extends BaseController
{
  public function showView()
  {
      return View::make('university.add_subject');
  }

  public function addSubject()
  {
    $subject = new Subject;
    $subject->name = Input::get('subject_name');
    $subject->university_id = Auth::id();
    $subject->division = Input::get('division');
    $sections = explode(',', Input::get('section'));

    foreach($sections as $section)
    {
      $sect = new Section;
      $sect->code = trim($section);
      $sect->is_free = true;
      $subject->sections()->associate($sect);
    }

    $subject->save();

    return Redirect::to('add_subject')->with('message', 'Subject successfully registered!');
  }

  public static function getSubjects()
  {
      return Subject::where('university_id', '=', Auth::id())->get();
  }

  public function showAllSubjectsView ()
  {
      return View::make('university.show_all_subjects')->with(array( 'subjects' => $this->getSubjects()));
  }


}
