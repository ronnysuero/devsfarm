<?php

class PendingEnrollmentController extends BaseController
{
	public function drop()
	{
		if(Request::ajax())
		{
			$pending = PendingEnrollment::find(Input::get('id'));
			
			try
			{
				$pending->delete();	
			}
			catch(Exception $e)
			{
				return Response::json($e);
			}
			
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
}