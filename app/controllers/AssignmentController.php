<?php

class AssignmentController extends BaseController{


public function addAssignment()
    {

        $user = Student::find(Auth::id());

        $assignment=new Assignment;
        $assignment->description=trim(Input::get('description'));
        $assignment->group_id= new MongoId(Input::get('id'));
        $assignment->state=trim("Por Asignar");
        $assignment->date_assigned=new MongoDate;
        $assignment->rated=null;
        $assignment->score=null;
        $assignment->assigned_by=null;
        $assignment->assigned_to=null;
        $assignment->deadline=null;


        $assignment->save();
        
        return Redirect::to(Lang::get('routes.find_group'))->with('message', Lang::get('register_assignment.success'));
    }


    public function AssignmentTo()
    {

        $user = Student::find(Auth::id());

        $assignment=new Assignment;
        $assignment->assigned_by= new MongoId($user->_id);
        $assignment->assigned_to=new MongoId(Input::get('students'));
        $assignment->state=trim("Asignado");
        $assignment->deadline=new MongoDate(strtotime(Input::get('deadline')));
       

        $assignment->save();
        
        //return Redirect::to(Lang::get('register_assignment.register_assignment'))->with('message', Lang::get('register_assignment.success'));
         //return Redirect::to(Lang::get('routes.student'))->with('message', Lang::get('register_assignment.success'));
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


}