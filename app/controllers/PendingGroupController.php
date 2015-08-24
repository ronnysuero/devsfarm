<?php

class PendingGroupController extends BaseController
{
	public function showJoinToGroupView()
	{
		$sectionCodes = SectionCode::where('status', true)
								   ->whereIn('students_id', array(Auth::id()))
								   ->get();
		$sections = array();
		$pending = PendingGroup::where('student_id', Auth::id())->get();

		foreach ($sectionCodes as $sectionCode) 
		{
			$subject = Subject::find($sectionCode->subject_id);

			if(isset($subject->_id))
			{
				$section = $subject->sections()->find($sectionCode->section_id);
				$sections[$sectionCode->_id] = $subject->name.' - '.$section->code;
			}
		}

		return View::make('student.join_to_group')->with(
			array( 
				'sections' => $sections,
				'pending' => $pending,
			)
		);
	}

	public function joinToGroup()
	{
		// $user = Student::find(Auth::id());
		// Group::find(new MongoId(Input::get('group')))->push('students_id', array(new MongoId($user->_id)));

		// return Redirect::to(Lang::get('routes.join_to_group'))->with('message', Lang::get('register_group.success'));

		$group  = Group::find(new MongoId(Input::get('group')));
		$pending = new PendingGroup;
		$pending->section_code_id = new MongoId(Input::get('section'));
		$pending->group_id = new MongoId($group->_id);
		$pending->student_id = Auth::id();
		$pending->teamleader_id = new MongoId($group->teamleader_id);

		try
		{
			$pending->save();
		}
		catch (MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(
				array( 
					'error' => Lang::get('register_group.join_pending')
				)
			);
		}

		return Redirect::to(Lang::get('routes.join_to_group'))->with('message', Lang::get('register_group.join_sucess'));
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$pending = PendingGroup::find(Input::get('id'));
			$pending->delete();	

			return Response::json("00");
		}
	}
}