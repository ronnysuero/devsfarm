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


        $group = Group::where('student_id', Auth::id())->get();

        return View::make('Group.show_group')->with(array( 'groups' => $group));


    }

    public function findMemberInformation()
    {
        if(Request::ajax())
        {
            $student = Student::where('email', '=', Input::get('email'))->first();
            return Response::json($student);
        }
    }

    public function getFarmReport(){
        $group_id = Input::get('group_id');
        return View::make('teacher.farm_report')->with(array('group_id' => $group_id,
                                                            'stats' => MessageController::getStats(),
                                                             'unreadMessages' => MessageController::unReadMessages()));
    }

    public function findGroupBySection()
    {

        $groups = Group::where('section_id', trim(strtolower(Input::get('section_code'))))->get();
        $colors = ['#673AB7', '#009688', '#00BCD4', '#673AB7', '#9C27B0', '#E91E63', '#F44336', '#2196F3', '#4CAF50',
            '#8BC34A', '#FFC107', '#795548', '#9E9E9E', '#CDDC39', '#607D8B'];


        return View::make('teacher.subject_details')->with(array('groups' => $groups,
                                                                'colors' => $colors,
                                                                'stats' => MessageController::getStats(),
                                                                'unreadMessages' => MessageController::unReadMessages()));
    }

    public function addStudentToGroup()
    {

        $user = Student::find(Auth::id());
        Group::find(Input::get('group'))->push('student_id', array(new MongoId($user->_id)));

        return Redirect::to(Lang::get('routes.join_to_group'))->with('message', Lang::get('register_group.success'));
    }

}


