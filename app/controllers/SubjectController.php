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
    $subject->school = Input::get('school');
    $sections = explode(',', Input::get('section'));

    foreach($sections as $section)
    {
      $sect = new Section;
      $sect->code = trim($section);
      $sect->is_free = true;
      $subject->sections()->associate($sect);
    }

    $subject->save();

    return Redirect::to('add_subject')->with('message', Lang::get('add_subject.success'));
  }

  public static function getSubjects()
  {
      return Subject::where('university_id', '=', Auth::id())->get();
  }

  public function showAllSubjectsView ()
  {
      return View::make('university.show_all_subjects')->with(array( 'subjects' => $this->getSubjects()));
  }

  public function find()
  {
      if(Request::ajax())
      {
        $subject = Subject::where('name', '=', Input::get('name'))->where('university_id', '=', Auth::id())->first();
        return Response::json($subject);
      }
  }
}
