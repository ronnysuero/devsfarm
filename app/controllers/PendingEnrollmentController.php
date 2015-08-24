<?php

class PendingEnrollmentController extends BaseController
{
	public function drop()
	{
		if(Request::ajax())
		{
			$pending = PendingEnrollment::find(Input::get('id'));
			$pending->delete();	

			return Response::json("00");
		}
	}

	public function approve()
	{
		if(Request::ajax())
		{
			$pending = PendingEnrollment::find(Input::get('id'));
			SectionCode::find($pending->section_code_id)->push('students_id', $pending->student_id, true);
			$pending->delete();
			
			return Response::json(array('code' => "00", 'stats' => MessageController::getStats()));
		}
	}

	public function showEnrollSection()
	{
		$sections  = SectionCode::whereIn('students_id', array(Auth::id()))
								->where('status', true)
								->get();
		
		$pending = PendingEnrollment::where('student_id', Auth::id())->get();

		return View::make('student.show_all_enrollment')->with(
			array( 
				'sections' => $sections,
			   	'pending' => $pending,
			)
		);
	}
	
	public function enrollSection()
	{
		$sectionCode = SectionCode::where('code', Input::get('code'))->first();

		if(isset($sectionCode->_id))
		{
			$section = Subject::find($sectionCode->subject_id)->sections()->find($sectionCode->section_id);
			$message = "";

			if(strcasecmp($section->current_code, $sectionCode->code) === 0)
			{
				$codes = SectionCode::where('code', Input::get('code'))
									->whereIn('students_id', array(Auth::id()))
									->first();

				if(!isset($codes->_id))
				{
					$pending = new PendingEnrollment;
					$pending->section_code_id = new MongoId($sectionCode->_id);
					$pending->student_id = Auth::id();
					$pending->teacher_id = new MongoId($sectionCode->teacher_id);  
					
					try
					{
						$pending->save();
					}
					catch (MongoDuplicateKeyException $e)
					{
						return Redirect::back()->withErrors(
							array( 
								'error' => Lang::get('register_group.enroll_pending')
							)
						);
					}
					
					return Redirect::to(Lang::get('routes.enroll_section'))->with('message', Lang::get('register_group.enroll_sucess'));
				}
				else
					$message = Lang::get('register_group.user_register');
			}
			else
				$message = Lang::get('register_group.code_expired');
		}
		else
			$message = Lang::get('register_group.code_fail');

		return Redirect::back()->withErrors(
			array( 
				'error' => $message
			)
		);
	}
}