<?php

class GroupController extends BaseController{

    /**
     * Show the view on the navigator
     *
     * @return void
     */

    public function  registerGroup(){

           $group = Group::whereIn('student_id', array(Auth::id()))
            ->get();

        return View::make('group.register_group')->with(array( 'groups' => $group,'stats' => MessageController::getStats(),
            'unreadMessages' => MessageController::unReadMessages()));

    }
    public function  joinToGroup(){

         $group = Group::whereIn('student_id', array(Auth::id()))
            ->get();

        return View::make('group.join_to_group')->with(array( 'groups' => $group,'stats' => MessageController::getStats(),
            'unreadMessages' => MessageController::unReadMessages()));

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
        $sectionCode = SectionCode::where('code', Input::get('sectionCode'))->first();

        if(isset($sectionCode->_id))
        {
            $section = Subject::find($sectionCode->subject_id)->sections()->find($sectionCode->section_id);

            if(strcasecmp($section->current_code, $sectionCode->code) === 0)
            {
                $group=new Group;
                $group->name=trim(strtolower(Input::get('name')));
                $group->teamleader_id= new MongoId($user->_id);
                $group->section_code = $sectionCode->code;
                $group->student_id=array(new MongoId($user->_id));
                $group->project_name=trim(strtolower(Input::get('project_name')));

                if(Input::hasFile('avatar_file'))
                {
                    $data = Input::get('avatar_data');
                    $image = new CropImage(null, $data, $_FILES['avatar_file']);
                    $group->logo = $image->getURL();
                }
                else
                    $group->logo = null;

                $group->save();

                return Redirect::to(Lang::get('routes.register_group'))->with('message', Lang::get('register_group.success'));
            }
            else
                return Redirect::back()->withErrors(array( 'error' => Lang::get('register_group.code_expired')));
        }
        else
            return Redirect::back()->withErrors(array( 'error' => Lang::get('register_group.code_fail')));
    }



    public function showAllGroupView()
    {  
        $group = Group::whereIn('student_id', array(Auth::id()))
            ->get();

        return View::make('group.show_group')->with(array( 'groups' => $group,'stats' => MessageController::getStats(),
            'unreadMessages' => MessageController::unReadMessages()));


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


     public static function findGroup()
    {
    
    
         
          $groups = Group::find(Input::get('group_code'));
          $task=Assignment::Where('group_id', new MongoId(Input::get('group_code')))->get();
     
        return View::make('group.show_mygroup')->with(array('groups' => $groups,'tasks'=>$task,'stats' => MessageController::getStats(),
            'unreadMessages' => MessageController::unReadMessages())
            );

       
    }


    public function find_students(){


        if(Request::ajax())
        {
           $group=Group::find(Input::get('group'));
           $students = array();

           if(isset($group->_id))
           {
                foreach ($group->student_id as $student) 
                {
                    $val = Student::find($student);
                    array_push($students, $val);
                }
           }
            //$students = Student::whereIn('_id',Input::get('group')->student_id)->get(); 
            //$students = Group::whereIn('_id',$group->student_id)->get();
            //$students = Student::all();

            if(count($students) > 0)
                //return View::make('student.home')->with();
                return Response::json(array('students' => $students));

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

}
