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
			$tasks = Assignment::where('group_id', new MongoId($group->_id))->get();
			$students = Student::whereIn('_id', $group->students_id)->get();

			return View::make('student.show_all_assignment')->with(
				array(
					'group' => $group,
					'tasks' => $tasks,
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
		$assignment->score = trim(Input::get('score'));
		$assignment->assigned_by = Auth::id();	
		$assignment->assigned_to = new MongoId(Input::get('students'));
		$assignment->deadline = new MongoDate(strtotime(Input::get('deadline')));

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
		$assignment->score = trim(Input::get('scoreEdit'));
		$assignment->assigned_to = new MongoId(Input::get('studentsEdit'));
		$assignment->deadline = new MongoDate(strtotime(Input::get('deadlineEdit')));
		$assignment->save();

		return Redirect::to(Lang::get('routes.show_all_assignment'))->with('message', Lang::get('register_assignment.update'));
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$assignment = Assignment::find(Input::get('id'));
			$assignment->delete();

			return Response::json("00");
		}
	}

	public function rated()
	{
		$task = Input::get('task');
		$assignment = Assignment::find(new MongoId($task));
  
        if(Input::get('rated')<=$assignment->score)
        {	
			$assignment->rated=Input::get('rated');
			$assignment->save();

			return Redirect::to(Lang::get('routes.find_Group'))->with(
				array(
					'group_code' => Input::get('group_id'),
					'message', Lang::get('rated.success')
				)
			);
		}
	}
}