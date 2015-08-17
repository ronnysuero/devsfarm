<?php

class SectionCodeController extends BaseController
{
	public function showAllSectionsCodesView()
	{
		$teacher = Teacher::find(Auth::id());
		$subjects = Subject::whereIn('_id', $teacher->subjects_id)->get();
		$section_codes = SectionCode::where('teacher_id', $teacher->_id)->get();

		return View::make('teacher.section_codes')->with(array( 'subjects' => $subjects,
																'teacher_section_id' => $teacher->sections_id,
																'section_codes' => $section_codes,
																'stats' => MessageController::getStats(),
																'unreadMessages' => MessageController::unReadMessages()));
	}


	public function getInitialLetters($word)
	{
		$words = explode(' ', $word);
		$acronym = '';

		foreach ($words as $w)
			$acronym .= $w[0];
	
		return $acronym;
	}

	public function addSectionCode()
	{
		$section_code = new SectionCode;

		$teacher = Teacher::find(Auth::Id());
		$subject_id = Input::get('subject');
		$section_id = Input::get('section');
		$current_period = Input::get('current_period');

		$section_code->teacher_id = $teacher->_id;
		$section_code->subject_id = $subject_id;
		$section_code->section_id = $section_id;
		$section_code->current_period = $current_period;
		$section_code->teamleaders_id = array();
		$section_code->students_id = array();

		$subject = Subject::find($subject_id);
		$section = $subject->sections()->find($section_id);

		$code =  $this->getInitialLetters($subject->name) .'-'. $section->code .'-'. $current_period;
		$section_code->code = $code;

		try
		{
			$section_code->save();
			$section->current_code = $code;
			$section->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(array( 'error' => Lang::get('section_codes.duplicate_code')));
		}
		
		return Redirect::to(Lang::get('routes.section_codes'))->with(array('message' => Lang::get('section_codes.success_message')));
	}
}