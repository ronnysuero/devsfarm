<?php

use Helpers\CropImage\CropImage;

class GroupController extends BaseController
{
	private $colors = [ '#673AB7', '#009688', '#00BCD4', '#673AB7', '#9C27B0', '#E91E63', '#F44336', 
						'#2196F3', '#4CAF50', '#8BC34A', '#FFC107', '#795548', '#9E9E9E', '#CDDC39', 
						'#607D8B'];

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
				'groups' => $groups,
                'colors' => $this->colors
			)
		);
	}

	public function find()
	{
		if(Request::ajax())
		{
			if(!is_null(Input::get('group_id')))
			{
				$group = Group::find(Input::get('group_id'));

				if(isset($group->_id))
					return Response::json($group);
				else
					return Response::json("");
			}
			else if(!is_null(Input::get('section_code')))
			{
				$section_code = SectionCode::where('code', Input::get('section_code'))->first();
				$groups = Group::where('section_code_id', new MongoId($section_code->_id))->get();

				return Response::json($groups);
			}
			else
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
	}

	public function update()
	{
		$group = Group::find(Input::get('group_id'));

		if(isset($group->_id))
		{
			$group->name = trim(ucfirst(Input::get('name')));
			$group->project_name = trim(strtolower(Input::get('project_name')));

			if(Input::hasFile('avatar_file'))
			{
				$data = Input::get('avatar_data');

				if(is_null($group->logo))
				{
					$image = new CropImage(null, $data, $_FILES['avatar_file']);
					$group->logo = $image->getURL();
				}
				else
					new CropImage($group->logo, $data, $_FILES['avatar_file']);
			}

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

			return Redirect::to(Lang::get('routes.student'))->with('message', Lang::get('register_group.update'));
		}
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$group = Group::find(Input::get('group_id'));
			$group->delete();
			return Response::json("00");
		}
	}

	public function findGroupBySection()
	{
		$section_code = SectionCode::where('code', Input::get('section_code'))->first();
		$groups = Group::where('section_code_id', new MongoId($section_code->_id))->get();

		

		return View::make('teacher.subject_details')->with(
			array(
				'groups' => $groups,
				'colors' => $this->colors
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
        $group = Group::where('_id', new MongoId($group_id))->first();

        $students = Student::whereIn('_id', $group->students_id)->get();

        $total_assignments = Assignment::where('group_id', new MongoId($group_id))->count();
        $total_completed = Assignment::where('group_id', new MongoId($group_id))->where('state', 'c')->count();
        $total_incompleted = Assignment::where('group_id', new MongoId($group_id))->whereIn('state', array('n', 'nc'))->count();
        $total_pending = Assignment::where('group_id', new MongoId($group_id))->whereIn('state', array('a', 'r', 'p'))->count();


        $student_task = TeacherController::getStatStudents($group->students_id, $group_id);

        $assignments = Assignment::where('group_id', new MongoId($group_id))->get();

		return View::make('teacher.farm_report')->with(
			array(
				'students' => $students,
                'total_assignments' => $total_assignments,
                'total_completed' => $total_completed,
                'total_incompleted' => $total_incompleted,
                'total_pending' => $total_pending,
                'student_task' => $student_task,
                'colors' => $this->colors,
                'assignments' => $assignments,
                'group' => $group
			)
		);
	}

	private static function COLOR($class)
	{
		return $class->colors;
	}

	public static function getColors($rand = null) 
	{	
		$color = GroupController::COLOR(new GroupController);
		return is_null($rand) ? $color : $color[rand(0, 14)];
	}
}
