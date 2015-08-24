<?php

class GroupController extends BaseController
{
	/**
	 * Show the view on the navigator
	 *
	 * @return void
	 */
	public function showAddGroupView()
	{
		$sectionCodes = SectionCode::where('status', true)
								   ->whereIn('teamleaders_id', array(Auth::id()))
								   ->get();
		$sections = array();

		foreach ($sectionCodes as $sectionCode) 
		{
			$subject = Subject::find($sectionCode->subject_id);

			if(isset($subject->_id))
			{
				$section = $subject->sections()->find($sectionCode->section_id);
				$sections[$sectionCode->_id] = $subject->name.' - '.$section->code;
			}
		}

		return View::make('student.add_group')->with(
			array( 
				'sections' => $sections,
			)
		);
	}
	
	public function addGroup()
	{
		$sectionCode = SectionCode::find(new MongoId(Input::get('section')));

		if(isset($sectionCode->_id))
		{
			$section = Subject::find($sectionCode->subject_id)->sections()->find($sectionCode->section_id);

			if(strcasecmp($section->current_code, $sectionCode->code) === 0)
			{
				$group = new Group;
				$group->name = trim(ucfirst(Input::get('name')));
				$group->teamleader_id = Auth::id();
				$group->section_code_id = new MongoId($sectionCode->_id);
				$group->students_id = array(Auth::id());
				$group->project_name = trim(strtolower(Input::get('project_name')));
				
				$message = "";

				if(Input::hasFile('avatar_file'))
				{
					$data = Input::get('avatar_data');
					$image = new CropImage(null, $data, $_FILES['avatar_file']);
					$group->logo = $image->getURL();
				}
				else
					$group->logo = null;

				try
				{
					$group->save();
				}
				catch (MongoDuplicateKeyException $e) 
				{
					return Redirect::back()->withErrors(
						array( 
							'error' => Lang::get('register_group.duplicated')
						)
					);
				}

				return Redirect::to(Lang::get('routes.add_group'))->with('message', Lang::get('register_group.success'));
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

	public function showAllGroupView()
	{
		$groups = Group::whereIn('students_id', array(Auth::id()))->get();

		return View::make('student.show_all_group')->with(
			array( 
				'groups' => $groups
			)
		);
	}

	public function find()
	{
		if(Request::ajax())
		{
			$pending = PendingGroup::where('student_id', Auth::id())->get();
			$array = array();

			foreach ($pending as $value) 
				array_push($array, $value->group_id);

			$groups = Group::where('section_code_id', new MongoId(Input::get('section_code')))
						   ->whereNotIn('students_id', array(Auth::id()))
						   ->whereNotIn('_id', $array)
						   ->get();

			if(count($groups) > 0)
			{
				return Response::json(
					array(
						'groups' => $groups,
					)
				);
			}
			else
				return Response::json("");
		}
	}

	public function findGroupBySection()
	{

		$groups = Group::where('section_id', trim(strtolower(Input::get('section_code'))))->get();

		$colors = [ '#673AB7', '#009688', '#00BCD4', '#673AB7', '#9C27B0', '#E91E63', '#F44336', 
					'#2196F3', '#4CAF50', '#8BC34A', '#FFC107', '#795548', '#9E9E9E', '#CDDC39', 
					'#607D8B'];

		return View::make('teacher.subject_details')->with(
			array(
				'groups' => $groups,
				'colors' => $colors
			)
		);
	}
	
	public function findMemberInformation()
	{
		if(Request::ajax())
		{
			$student = Student::where('email', Input::get('email'))->first();

			return Response::json($student);
		}
	}

	public function getFarmReport()
	{
		$group_id = Input::get('group_id');

		return View::make('teacher.farm_report')->with(
			array(
				'group_id' => $group_id
			)
		);
	}

	public static function findGroup()
	{

		if(Input::get('group_code') != null || Session::get('group_code'))
		{
			$id = (Input::get('group_code') != null) ? Input::get('group_code') : Session::get('group_code');
			$group = Group::find(new MongoId($id));
			$task=Assignment::where('group_id', new MongoId($id))->get();

			return View::make('student.show_mygroup')->with(
				array(
					'groups' => $group,
					'tasks' => $task
				)
			);	
		}
		else
			return Redirect::to(Lang::get('routes.student'));
	}

	public function find_students()
	{
		$usuario = array();
		$user = Student::find(Auth::id());
		array_push($usuario, $user);

		if(Request::ajax())
		{
			$group = Group::find(Input::get('group'));
			$students = array();

			if(isset($group->_id))
			{
				foreach ($group->student_id as $student) 
				{
					$val = Student::find($student);

					if(isset($val->_id))
						array_push($students, $val);
				}
			}

			if(count($students) > 0 && $user->_id === $group->teamleader_id)
				return Response::json(array('students' => $students));
			else
				return Response::json(array('students' => $usuario));
		}
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$ids = Input::get('group_id');
			Group::find($ids)->delete();

			return Response::json("00");
		}
	}

	public function findupdateGroup()
	{
		if(Request::ajax())
		{
			$ids = Input::get('group_id');
			$group = Group::find(new MongoId($ids));

		return Response::json(array('group' =>  $group));
		}
	}
}
