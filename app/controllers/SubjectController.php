<?php

class SubjectController extends BaseController
{
    public function showView()
    {
        return View::make('university.add_subject')->with(array('stats' => MessageController::getStats(),
                                                                'unreadMessages' => MessageController::unReadMessages()));
    }

    public function addSubject()
    {
        $subject = new Subject;
        $subject->name = strtoupper(trim(Input::get('subject_name')));
        $subject->university_id = Auth::id();
        $subject->school = strtoupper(trim(Input::get('school')));
        $sections = explode(',', Input::get('section'));

        foreach($sections as $section)
        {
            $sect = new Section;
            $sect->code = strtoupper(trim($section));
            $sect->is_free = true;
            $subject->sections()->associate($sect);
        }

        try
        {
            $subject->save();
        }
        catch(MongoDuplicateKeyException $e)
        {
            return Redirect::back()->withErrors(array( 'error' => Lang::get('add_subject.subject_duplicated')));
        }

        return Redirect::to(Lang::get('routes.add_subject'))->with('message', Lang::get('add_subject.success'));
    }

    public static function getSubjects()
    {
        return Subject::where('university_id', Auth::id())->get();
    }

    public function showAllSubjectsView ()
    {
        return View::make('university.show_all_subjects')->with(array(  'subjects' => $this->getSubjects(),
                                                                        'stats' => MessageController::getStats(),
                                                                        'unreadMessages' => MessageController::unReadMessages()));
    }

    public function update()
    {
        $subject = Subject::find(Input::get('_id'));
        $subject->name = strtoupper(trim(Input::get('subject_name')));
        $subject->school = strtoupper(trim(Input::get('school')));
        
        try
        {
            $subject->save();
        }
        catch(MongoDuplicateKeyException $e)
        {
            return Redirect::back()->withErrors(array( 'error' => Lang::get('add_subject.subject_duplicated')));
        }

        return Redirect::to(Lang::get('routes.show_all_subjects'))->with('message', Lang::get('university_profile.update_message'));  
    }

    public function find()
    {
        if(Request::ajax())
        {
            $subject = Subject::where('name', Input::get('name'))->where('university_id', Auth::id())->first();
            return Response::json($subject);
        }
    }

    public function drop()
    {
        if(Request::ajax())
        {
            $subject = Subject::find(Input::get('subject_id'));

            foreach(Teacher::where('university_id', Auth::id())->get() as $teacher) 
            {
                if($teacher->whereIn('subjects_id', array(new MongoId($subject->_id)))->count() > 0)
                    return Response::json(Lang::get('add_subject.subject_used'));
            }   

            $subject->delete();

            if ($subject->trashed())
                return Response::json("00");
            else
                return Response::json("99");
        }
    }
}
