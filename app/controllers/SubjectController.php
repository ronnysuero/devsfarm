<?php

class SubjectController extends BaseController
{
	/**
	 * Show the view for add a subject
	 * 
	 * @return View
	 */
	public function showView()
	{
		return View::make('university.add_subject')->with(
			array(
				'stats' => MessageController::getStats(),
			)
		);
	}

	/**
	 * Store a subject in the Subject collection
	 * 
	 * @return View
	 */
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
			return Redirect::back()->withErrors(
				array( 
					'error' => Lang::get('add_subject.subject_duplicated')
				)
			);
		}

		return Redirect::to(Lang::get('routes.add_subject'))->with('message', Lang::get('add_subject.success'));
	}

	/**
	 * Return the subject an University
	 * 
	 * @return Array(Subject)
	 */
	public static function getSubjects()
	{
		return Subject::where('university_id', Auth::id())->get();
	}

	/**
	 * Show all subjects of an University 
	 * 
	 * @return View
	 */
	public function showAllSubjectsView ()
	{
		return View::make('university.show_all_subjects')->with(
			array(  
				'subjects' => $this->getSubjects(),
				'stats' => MessageController::getStats(),
			)
		);
	}

	/**
	 * Update the data of a Subject
	 * 
	 * @return View
	 */
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
			return Redirect::back()->withErrors(
				array( 
					'error' => Lang::get('add_subject.subject_duplicated')
				)
			);
		}

		return Redirect::to(Lang::get('routes.show_all_subjects'))->with('message', Lang::get('university_profile.update_message'));  
	}

	/**
	 * Find a subject of an University
	 * 
	 * @return JSON Ajax
	 */
	public function find()
	{
		if(Request::ajax())
		{
			$subject = Subject::where('name', Input::get('name'))->where('university_id', Auth::id())->first();
			return Response::json($subject);
		}
	}

	/**
	 * Remove the subjects of an University
	 * 
	 * @return JSON Ajax
	 */
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

			return Response::json($subject->trashed() ? "00" : "99");
		}
	}
}
