<?php

class SectionController extends BaseController
{
	public function showView()
	{
		return View::make('university.add_section')->with(array('subjects' => Subject::where('university_id', '=', Auth::id())->get()));
	}

	public function showAllSectionsView()
	{
		$subjects = Subject::where('university_id', '=', Auth::id())->get();   
		return View::make('university.show_all_sections')->with(array( 'subjects' => $subjects));
	}

	public function find()
	{
		if(Request::ajax())
		{
			if(Input::get('_id') !== null)
			{
				$subject = Subject::where('_id', '=', Input::get('_id'))->where('university_id', '=', Auth::id())->first();
				
				if($subject !== null)
					return Response::json(array('subject' => $subject, 'sections' => $subject->sections));
			}
			else if (Input::get('code') !== null && Input::get('subject_id') !== null)
			{
				$subject = Subject::where('_id', '=', Input::get('subject_id'))->where('university_id', '=', Auth::id())->first();
				
				if($subject !== null)
				{
					$section = $subject->sections()->where('code', '=', Input::get('code'))->first();
					return Response::json(array('section' => $section, 'subject_id' => $subject->_id));
				}
			}
		}
	}

	public function findUnusedSection()
	{
		if(Request::ajax())
		{
			$subject = Subject::where('_id', '=', Input::get('_id'))->where('university_id', '=', Auth::id())->first();
			$sections = $subject->sections()->where('is_free', '=', true)->get();

			if(count($sections) > 0)
				return Response::json(array('subject' => $subject->_id, 'sections' => $sections));
		}
	}

	public function addSection()
	{
		$subject = Subject::where('_id', '=', new MongoId(Input::get('_id')))->first();
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
		$subject = Subject::where('_id', '=', new MongoId(Input::get('subject_id')))->first();
		$section = $subject->sections()->where('_id', '=', Input::get('_id'))->first();
		$section->code = strtoupper(trim(Input::get('section_code')));
		
		try
		{
			$subject->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(array( 'error' => Lang::get('add_section.section_duplicated')));
		}

		return Redirect::to(Lang::get('routes.show_all_sections'))->with('message', Lang::get('university_profile.update_message'));  
	}
}