<?php

use Helpers\CropImage\CropImage;

class TeacherController extends BaseController
{
	public static function getTeachers()
	{
		return Teacher::where('university_id', Auth::id())->get();
	}

	public function showView ()
	{
		return View::make('university.add_teacher')->with(array('stats' => MessageController::getStats(),
															    'unreadMessages' => MessageController::unReadMessages()));
	}

	public function showHome()
	{
		return View::make('teacher.home')->with(array('stats' => MessageController::getStats(),
                                                        'unreadMessages' => MessageController::unReadMessages()));
	}
	public function showProfile()
	{
		return View::make('teacher.profile')->with(array('teacher' => Teacher::find(Auth::id()),
                                                        'stats' => MessageController::getStats(),
                                                        'unreadMessages' => MessageController::unReadMessages()));
	}

	public function showSubjectDetails()
	{
		return View::make('teacher.subject_details');
	}

	public function showFarmReport()
	{
		return View::make('teacher.farm_report');
	}

	public function showAllTeachersView ()
	{
		return View::make('university.show_all_teachers')->with(array(  'teachers' => $this->getTeachers(),
																		'stats' => MessageController::getStats(),
														  				'unreadMessages' => MessageController::unReadMessages()));
	}

	public function addTeacher()
	{
		$user = new User;
		$user->user = trim(strtolower(Input::get('email')));
		$user->password = Hash::make(Input::get('email'));
		$user->rank = "teacher";
		$user->last_activity = null;

		try
		{
			$user->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(array( 'error' => Lang::get('register_student.email_duplicated')));
		}

		$user = User::first(['user' => $user->user]);

		$teacher = new Teacher;
		$teacher->_id = $user->_id;
		$teacher->university_id = Auth::id();
		$teacher->name = trim(Input::get('name'));
		$teacher->last_name = trim(Input::get('last_name'));
		$teacher->phone = trim(Input::get('phone'));
		$teacher->cellphone = trim(Input::get('cellphone'));
		$teacher->email = trim(strtolower(Input::get('email')));
		$teacher->subjects_id = array();
		$teacher->sections_id = array();

		if(Input::hasFile('avatar_file'))
		{
			$data = Input::get('avatar_data');
			$image = new CropImage(null, $data, $_FILES['avatar_file']);
			$teacher->profile_image = $image->getURL();
		}
		else
			$teacher->profile_image = null;

		$teacher->save();

		return Redirect::to(Lang::get('routes.add_teacher'))->with('message', Lang::get('register_teacher.success'));
	}

	public function update()
	{
		$teacher = Teacher::find(new MongoId(Input::get('_id')));
		$email = trim(strtolower(Input::get('email')));

		if(strcmp($email, $teacher->email) !== 0)
		{
			$user = User::first(['_id' => $teacher->_id]);
			$user->user = $email;

			try
			{
				$user->save();
			}
			catch(MongoDuplicateKeyException $e)
			{
				return Redirect::back()->withErrors(array( 'error' => Lang::get('register_student.email_duplicated')));
			}

			$teacher->email = $email;
		}

		$teacher->name = ucfirst(trim(Input::get('name')));
		$teacher->last_name = ucfirst(trim(Input::get('last_name')));
		$teacher->phone = trim(Input::get('phone'));
		$teacher->cellphone = trim(Input::get('cellphone'));
		$teacher->save();

		return Redirect::to(Lang::get('routes.show_all_teachers'))->with('message', Lang::get('university_profile.update_message'));
	}

    public function updateTeacher(){

        $teacher = Teacher::find(Auth::id());
        $teacher->name = ucfirst(trim(Input::get('teacher_name')));
        $teacher->last_name = ucfirst(trim(Input::get('teacher_last_name')));
        $teacher->phone = trim(Input::get('teacher_phone'));
        $teacher->cellphone = trim(Input::get('teacher_cellphone'));

        if(strlen(Input::get('current_password')) > 0)
        {
            if(!Hash::check(Input::get('current_password'), Auth::user()->password))
                return Redirect::back()->withErrors(array( 'error' => Lang::get('teacher_profile.error_password')));
            else
                Auth::user()->password = Hash::make(Input::get('new_password'));
                Auth::user()->save();
        }

//        if(strcmp($email, $teacher->email) !== 0)
//        {
//            Auth::user()->last_activity = new MongoDate;
//            Auth::user()->user = $email;
//
//            try
//            {
//                Auth::user()->save();
//            }
//            catch(MongoDuplicateKeyException $e)
//            {
//                return Redirect::back()->withErrors(array( 'error' => Lang::get('register_university.email_duplicated')));
//            }
//
//            //$flag = true;
//            $teacher->email = $email;
//        }
//        else if(strlen(Input::get('current_password')) > 0)
//            Auth::user()->save();

        if(Input::hasFile('avatar_file'))
        {
            $data = Input::get('avatar_data');

            if($teacher->profile_image === null)
            {
                $image = new CropImage(null, $data, $_FILES['avatar_file']);
                $teacher->profile_image = $image->getURL();
            }
            else
                new CropImage($teacher->profile_image, $data, $_FILES['avatar_file']);
        }

        $teacher->save();

        return Redirect::to(Lang::get('routes.teacher_profile'))->with('message', Lang::get('teacher_profile.update_message'));
    }

	public function find()
	{
		if(Request::ajax())
		{
			$teacher = Teacher::where('email', Input::get('email'))->first();
			return Response::json($teacher);
		}
	}

	public function drop()
	{
		if(Request::ajax())
		{
			$teacher = Teacher::find(Input::get('teacher_id'));

			foreach (Subject::whereIn('_id', $teacher->subjects_id)->get() as $subject) 
			{
				foreach ($subject->sections()->whereIn('_id', $teacher->sections_id)->get() as $section) 
				{
					$section->is_free = true;
					$section->save();
				}
			}

			$teacher->unset('subjects_id');
			$teacher->unset('sections_id');	
			$teacher->delete();

			if ($teacher->trashed())
				return Response::json("00");
			else
				return Response::json("99");
		}
	}
}
