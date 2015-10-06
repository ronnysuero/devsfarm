<?php

class AssignmentController extends BaseController
{
	public function showAllAssignmentView()
	{	
		if(!is_null(Input::get('group_code')))
			Session::put('group_code', Input::get('group_code'));

		if(Session::has('group_code'))
		{
			$group = Group::find(new MongoId(Session::get('group_code')));
			$students = Student::whereIn('_id', $group->students_id)->get();

			return View::make('student.show_all_assignment')->with(
				array(
					'group' => $group,
					'assignments' => $this->evaluateAssignments($group->_id),
					'students' => $students,
				)
			);
		}
		else
			return Redirect::to(Lang::get('routes.student'));
	}
	
	public function addAssignment()
	{
		$assignment = new Assignment;
		$assignment->description = trim(Input::get('description'));
		$assignment->group_id = new MongoId(Input::get('id'));
		$assignment->state = 'a';
		$assignment->date_assigned = new MongoDate;
		$assignment->rated = null;
		$assignment->score = (float)trim(Input::get('score'));
		$assignment->assigned_by = Auth::id();	
		$assignment->assigned_to = new MongoId(Input::get('students'));
		$assignment->deadline = new MongoDate(strtotime(Input::get('deadline')));
		$assignment->tags = Input::get('tags');
		$assignment->save();
		
		return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.success'));
	}

	public function find()
	{
		if(Request::ajax())
		{
			$task = Assignment::find(new MongoId(Input::get('code')));
	
			if(isset($task->_id))
				return Response::json($task);
			else
				return Response::json("");	
		}
	}

	public function update()
	{
		$assignment = Assignment::find(new MongoId(Input::get('taskedit')));
		$assignment->description = trim(Input::get('descriptionEdit'));
		$assignment->score = (float)trim(Input::get('scoreEdit'));
		$assignment->assigned_to = new MongoId(Input::get('studentsEdit'));
		$assignment->deadline = new MongoDate(strtotime(Input::get('deadlineEdit')));

		$array = explode(",", strtoupper(trim(Input::get('tagsEdit'))));
		$newArray = array();

		foreach ($array as $value)
			array_push($newArray, trim($value));

		$assignment->tags = $newArray;
		$assignment->save();

		return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.update'));
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$assignment = Assignment::find(Input::get('id'));
			
			foreach ($assignment->attachments as $file) 
				File::delete(storage_path().'/assignments/'.$assignment->_id.'/'.$file);

			File::delete(storage_path().'/assignments/'.$assignment->_id);

			$assignment->delete();

			return Response::json("00");
		}
	}

	public function evaluateAssignments($group_id)
	{
		$assignments = Assignment::where('group_id', new MongoId($group_id))->get();
		$array = array();

		foreach ($assignments as $assignment) 
		{
			$deadline = new DateTime(date('Y-m-d', $assignment->deadline->sec));
			$date = new DateTime(date('Y-m-d'));

			if($deadline < $date && is_null($assignment->rated))
			{
				$assignment->rated = 0;
				$assignment->state = 'n';
				$assignment->save();			
			}

			array_push($array, $assignment);
		}

		return $array;
	}

	public function reassign()
	{
		$assignment = Assignment::find(new MongoId(Input::get('taskReassined')));
		$assignment->state = "nc";
		$assignment->save();
		
		$new = new Assignment;
		$new->description = $assignment->description;
		$new->group_id = new MongoId($assignment->group_id);
		$new->state = 'r';
		$new->rated = null;
		$new->date_assigned = new MongoDate;
		$new->score = $assignment->score;
		$new->assigned_by = new MongoId($assignment->assigned_by);
		$new->assigned_to = new MongoId(Input::get('studentsReassigned'));
		$new->deadline = new MongoDate(strtotime(Input::get('deadlineReassigned')));
		$new->reference = new MongoId($assignment->_id);
		$new->save();
		
		return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.reassigned'));
	}

	public function uploadAssignment()
	{
		$assignment = Assignment::find(Input::get('taskupdate'));

		if(isset($assignment->_id))
		{
			 $assignmentsFiles = array();

			if(Input::hasFile('files'))
			{
				$path = storage_path().'/assignments/'.$assignment->_id;
				$array = Input::file('files');

				if (!File::exists($path))
					File::makeDirectory($path);

				foreach ($array as $file) 
				{
					$filename = $file->getClientOriginalName();
					$file->move($path, $filename);
					array_push($assignmentsFiles, $filename);
				}
			}

			$assignment->body = trim(Input::get('textarea'));
			$assignment->attachments = $assignmentsFiles;
			$assignment->state = 'p';
			$assignment->save();

			return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.update'));
		}
	}

	public static function enableViewDetailBtn($assignment)
	{
		if(isset($assignment->body) && isset($assignment->attachments))
		{
			if($assignment->body != '' || count($assignment->attachments) > 0)
				return true;
			else
				return false;
		}
	}

	public function rateAssignment()
	{
		$assignment = Assignment::find(Input::get('assignment_id'));
  		$rated = (float)Input::get('rated');
  		$note = ($assignment->score * $rated)/100;

  		if($note <= $assignment->score)
		{	
			$note = ($assignment->score * $rated)/100;
			$assignment->rated = $note;
			$assignment->state = 'c';
			
			$assignment->save();

			return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.rate_success'));
		}
	}

	public function cancelRequestAssignment()
	{
		if(Request::ajax())
		{
			$assignment = Assignment::find(new MongoId(Input::get('_id')));
			$assignment->state = 'a';
			$assignment->body = "";

			foreach ($assignment->attachments as $file) 
				File::delete(storage_path().'/assignments/'.$assignment->_id.'/'.$file);

			File::delete(storage_path().'/assignments/'.$assignment->_id);

			$assignment->attachments = array();
			$assignment->save();

			return Response::json('00');
		}
	}

    public static function getLatestAssignments()
    {
        $teacher = User::first(Auth::id());
        $last_activity = $teacher->last_activity;

        $assignments = Assignment::where('date_assigned', '>=', $last_activity)->get();

        return $assignments;
    }
}