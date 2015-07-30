<?php

class GroupController extends BaseController{

    /**
     * Show the view on the navigator
     *
     * @return void
     */

    public function  registerGroup(){

        return View::make('group.register_group');

    }
    public function  joinToGroup(){

        return View::make('group.join_to_group');

    }
    // quitar
    public function showView ()
    {
        $subjects=Subject::all();
        return View::make('group.register_group')->with(array( 'subjects' => $subjects));
    }


    public function addGroup()
    {

        $user = Student::find(Auth::id());

        $group=new Group;
        $group->name=trim(strtolower(Input::get('name')));
        $group->teamleader_id= new MongoId($user->_id);
        //$group->section_id= new MongoId(trim(strtolower(Input::get('idSubject'))));
        $group->section_id= trim(strtolower(Input::get('idSubject')));
        $group->student_id=array(new MongoId($user->_id));
        $group->project_name=trim(strtolower(Input::get('project_name')));


        if (Input::hasFile('logo'))
        {
            $file = Input::file('logo');
            $photoname = uniqid();
            $file->move(storage_path() . '/photos/imagesprofile', $photoname.'.'.$file->guessClientExtension());
            $image = Image::make(storage_path().'/photos/imagesprofile/'.$photoname.'.'.$file->guessClientExtension())->resize(140, 140)->save();
            $group->logo = '/photos/imagesprofile/' . $photoname.'.'.$file->guessClientExtension();
        }
        else
            $group->logo=null;


        $group->save();


        return Redirect::to(Lang::get('routes.register_group'))->with('message', Lang::get('register_group.success'));
    }



    public function showAllGroupView()
    {


        $group = Group::whereIn('student_id', array(Auth::id()))
            ->get();

        return View::make('Group.show_group')->with(array( 'groups' => $group));


    }

    public function findGroupBySection()
    {


        if(Request::ajax())
        {


            $groups = Group::where('section_id','=',Input::get('_id'))->get();




            if(count($groups) > 0)
                return Response::json(array('groups' =>  $groups));
        }
    }

    public function addStudentToGroup()
    {

        $user = Student::find(Auth::id());
        Group::find(Input::get('group'))->push('student_id', array(new MongoId($user->_id)));


        return Redirect::to(Lang::get('routes.join_to_group'))->with('message', Lang::get('register_group.success'));


    }

}


