<?php

class SectionController extends BaseController
{
	public function showView()
	{
		return View::make('university.add_section')->with(array('subjects' => Subject::where('university_id', Auth::id())->get(),
																'stats' => MessageController::getStats(),
														  		'unreadMessages' => MessageController::unReadMessages()));
	}

	public function showAllSectionsView()
	{
		$subjects = Subject::where('university_id', Auth::id())->get();

		return View::make('university.show_all_sections')->with(array(  'subjects' => $subjects,
																		'stats' => MessageController::getStats(),
														  				'unreadMessages' => MessageController::unReadMessages()));
	}

	public function find()
	{
		if(Request::ajax())
		{
			if(!is_null(Input::get('_id')))
			{
				$subject = Subject::find(Input::get('_id'))->where('university_id', Auth::id())->first();
				
				if($subject !== null)
					return Response::json(array('subject' => $subject, 'sections' => $subject->sections));
			}
			else if (!is_null(Input::get('code')) && !is_null(Input::get('subject_id')))
			{
				$subject = Subject::find(new MongoId(Input::get('subject_id')))->where('university_id', Auth::id())->first();
				
				if(!is_null($subject))
				{
					$section = $subject->sections()->where('code', Input::get('code'))->first();
					return Response::json(array('section' => $section, 'subject_id' => $subject->_id));
				}
			}
		}
	}

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

	public function addSection()
	{
		$subject = Subject::find(Input::get('_id'));
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
			return Redirect::back()->withErrors(array( 'error' => Lang::get('add_section.section_duplicated')));
		}

		return Redirect::to(Lang::get('routes.add_section'))->with('message', Lang::get('add_section.success'));
	}	

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

    public function showAllSectionsCodesView()
    {
        $teacher = $teacher = Teacher::where('_id', Auth::id() )->first();
        $subjects = Subject::whereIn('_id', $teacher->subjects_id)->get();

        return View::make('teacher.section_codes')->with(array( 'subjects' => $subjects,
                                                                'stats' => MessageController::getStats(),
                                                                'unreadMessages' => MessageController::unReadMessages()));
    }

    public function getSubjectSections(){

        if(Request::ajax())
        {
            $subject = Subject::where("_id", new MongoId(Input::get("_id")))->first();

            $teacher = Teacher::where('_id', Auth::id() )->first();
            $sections = $subject->sections()->whereIn('_id', $teacher->sections_id)->get();

            if(count($sections) > 0)
                return Response::json(array('subject' => $subject->_id, 'sections' => $sections));
        }
    }

    public function drop()
    {
    	if(Request::ajax())
    	{
    		$subject = Subject::find(Input::get('subject_id'));
			$section = $subject->sections()->find(Input::get('_id'));
			$section->delete();

			if ($section->trashed())
				return Response::json("00");
			else
				return Response::json("99");
    	}
    }
}