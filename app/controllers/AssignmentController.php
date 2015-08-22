<?php

class AssignmentController extends BaseController
{
	public function addAssignment()
    {
		$user = Student::find(Auth::id());

		$assignment=new Assignment;
		$assignment->description=trim(Input::get('description'));
		$assignment->group_id= new MongoId(Input::get('id'));
		$assignment->state=trim("Asignada");
		$assignment->date_assigned=new MongoDate;
		$assignment->rated=null;
		$assignment->score=trim(Input::get('score'));
		$assignment->assigned_by= new MongoId($user->_id);	
		$assignment->assigned_to=new MongoId(Input::get('students'));
		$assignment->state=trim("Asignado");
		$assignment->deadline=new MongoDate(strtotime(Input::get('deadline')));

        $assignment->save();
        
        return Redirect::to(Lang::get('routes.find_group'))->with('message', Lang::get('register_assignment.success'));
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

	public function updateTask()
	{
		$task = Input::get('taskedit');
		$assignment = Assignment::find(new MongoId($task));
		$assignment->description=trim(Input::get('descriptionedit'));
		//revisar si hay que agregar campo con fecha  de update
		$assignment->score=trim(Input::get('scoreedit'));
		$assignment->assigned_to=new MongoId(Input::get('studentsedit'));
		$assignment->deadline=new MongoDate(strtotime(Input::get('deadlineedit')));
		$assignment->save();

		return Redirect::to(Lang::get('routes.find_Group'))->with(
			array(
				'group_code' => Input::get('group_id'),
				'message', Lang::get('register_assignment.success')
			)
		);
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$ids = Input::get('_ids');
			
			foreach ($ids as $value) 
				Assignment::find($value)->delete();
			
			return Response::json("00");
		}
	}
 
	public function findTask()
	{
		if(Request::ajax())
		{
  			$id = Input::get('code');
			$task = Assignment::find(new MongoId($id));
  	
	  		if(isset($task->_id))
				return Response::json($task);	
		}
	}
}