<?php

class SectionController extends BaseController
{
    /**
     * Show view for add a new section
     * 
     * @return View
     */
    public function showView()
    {
        return View::make('university.add_section')->with(array('subjects' => Subject::where('university_id', Auth::id())->get(),
                                                                'stats' => MessageController::getStats(),
                                                                'unreadMessages' => MessageController::unReadMessages()));
    }

    /**
     * Show view of all sections of a subject
     * 
     * @return View
     */
    public function showAllSectionsView()
    {
        $subjects = Subject::where('university_id', Auth::id())->get();

        return View::make('university.show_all_sections')->with(array(  'subjects' => $subjects,
                                                                        'stats' => MessageController::getStats(),
                                                                        'unreadMessages' => MessageController::unReadMessages()));
    }

    /**
     * Return the sections belonging to a teacher
     * 
     * @return JSON Ajax
     */
    public function getSubjectSections()
    {
        if(Request::ajax())
        {
            $subject = Subject::where("_id", new MongoId(Input::get("_id")))->first();
            $teacher = Teacher::find(Auth::id());
            $sections = $subject->sections()->whereIn('_id', $teacher->sections_id)->get();

            if(count($sections) > 0)
                return Response::json(array('subject' => $subject->_id, 'sections' => $sections));
        }
    }

    /**
     * Find a section in the Section Collection
     * 
     * @return JSON Ajax
     */
    public function find()
    {
        if(Request::ajax())
        {
            if(!is_null(Input::get('_id')))
            {
                $subject = Subject::find(Input::get('_id'))->where('university_id', Auth::id())->first();
                
                if(isset($subject->_id))
                    return Response::json(array('subject' => $subject, 'sections' => $subject->sections()->get()));
            }
            else if (!is_null(Input::get('code')) && !is_null(Input::get('subject_id')))
            {
                $subject = Subject::find(new MongoId(Input::get('subject_id')))->where('university_id', Auth::id())->first();
                
                if(isset($subject->_id))
                {
                    $section = $subject->sections()->where('code', Input::get('code'))->first();
                    return Response::json(array('section' => $section, 'subject_id' => $subject->_id));
                }
            }
        }
    }

    /**
     * Find a unused section
     * 
     * @return JSON Ajax
     */
    public function findUnusedSection()
    {
        if(Request::ajax())
        {
            $subject = Subject::where('university_id', Auth::id())
                                ->where("_id", new MongoId(Input::get("_id")))
                                ->first();
        
            $sections = $subject->sections()->where('is_free', true)->whereNull('deleted_at')->get();

            if(count($sections) > 0)
                return Response::json(array('subject' => $subject->_id, 'sections' => $sections));
        }
    }

    /**
     * Store a new section in Section Collection
     * 
     * @return View
     */
    public function addSection()
    {
        $subject = Subject::find(Input::get('_id'));
        $sections = explode(',', Input::get('section'));

        foreach($sections as $section)
        {
            $sect = new Section;
            $sect->code = strtoupper(trim($section));
            $sect->is_free = true;
            $sect->current_code = null;
            $subject->sections()->associate($sect);
        }

        try
        {
            $subject->save();
        }
        catch(MongoDuplicateKeyException $e)
        {
            return Redirect::back()->withErrors(array( 'error' => Lang::get('add_section.section_duplicated')));
        }

        return Redirect::to(Lang::get('routes.add_section'))->with('message', Lang::get('add_section.success'));
    }   

    /**
     *  Update all data for a Section 
     * 
     * @return View
     */
    public function update()
    {  
        $subject = Subject::find(Input::get('subject_id'));
        $section = $subject->sections()->find(Input::get('_id'));
        $section->code = strtoupper(trim(Input::get('section_code')));
        
        try
        {
            $section->save();
        }
        catch(MongoDuplicateKeyException $e)
        {
            return Redirect::back()->withErrors(array( 'error' => Lang::get('add_section.section_duplicated')));
        }

        return Redirect::to(Lang::get('routes.show_all_sections'))->with('message', Lang::get('university_profile.update_message'));  
    }

    /**
     * Show all sections codes for a section
     * 
     * @return View
     */
    public function showAllSectionsCodesView()
    {
        return View::make('teacher.section_codes')->with(array('stats' => MessageController::getStats(),
                                                                'unreadMessages' => MessageController::unReadMessages()));
    }

    /**
     * Remove a section for the collection
     * 
     * @return JSON Ajax
     */
    public function drop()
    {
        if(Request::ajax())
        {
            $subject = Subject::find(Input::get('subject_id'));
            $section = $subject->sections()->find(Input::get('_id'));
            
            foreach(Teacher::where('university_id', Auth::id())->get() as $teacher) 
            {
                if($teacher->whereIn('sections_id', array(new MongoId($section->_id)))->count() > 0)
                    return Response::json(Lang::get('add_section.section_used'));
            }

            $section->delete();

            if ($section->trashed())
                return Response::json("00");
            else
                return Response::json("99");
        }
    }
}