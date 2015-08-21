<?php

class SectionCodeController extends BaseController
{
	public function showAllSectionsCodesView()
	{
		$teacher = Teacher::find(Auth::id());		
		$subjects = Subject::whereIn('_id', $teacher->subjects_id)->get();
		$section_codes = SectionCode::where('teacher_id', new MongoId($teacher->_id))
									->where('status', true)->get();

		return View::make('teacher.section_codes')->with(
			array( 
				'subjects' => $subjects,
				'teacher_section_id' => $teacher->sections_id,
				'section_codes' => $section_codes,
			)
		);
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

		$section_code->teacher_id = new MongoId($teacher->_id);
		$section_code->subject_id = new MongoId($subject_id);
		$section_code->section_id = new MongoId($section_id);
		$section_code->current_period = $current_period;
		$section_code->teamleaders_id = array();
		$section_code->students_id = array();
		$section_code->status = true;

		$subject = Subject::find($subject_id);
		$section = $subject->sections()->find($section_id);

		$code =  $this->getInitialLetters($subject->name).'-'.$section->code.'-'.$current_period;
		$section_code->code = $code;

		if(!is_null($section->current_code))
		{
			$sectionCode = SectionCode::where('code', $section->current_code)->first();
			$sectionCode->status = false;
			$sectionCode->save();
		}

		try
		{
			$section_code->save();
			$section->current_code = $code;
			$section->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(
				array( 
					'error' => Lang::get('section_codes.duplicate_code')
				)
			);
		}
		
		return Redirect::to(Lang::get('routes.section_codes'))->with(
			array(
				'message' => Lang::get('section_codes.success_message')
			)
		);
	}

	public function dropTeamleaderSectionCode()
	{
		if(Request::ajax())
		{
			$sectionCode = SectionCode::find(Input::get('code'));
			$sectionCode->pull('teamleaders_id', new MongoId(Input::get('student')));
			
			return Response::json("00");
		}
	}
}