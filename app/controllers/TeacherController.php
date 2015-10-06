<?php

use Helpers\CropImage\CropImage;

class TeacherController extends BaseController
{
    /**
     * Function that return all the teachers
     *
     * @return Array
     */
	public static function getTeachers()
	{
		return Teacher::where('university_id', Auth::id())->get();
	}

    /**
     * Function that return add_teacher view (Form)
     *
     * @return View
     */
	public function showView ()
	{
		return View::make('university.add_teacher');
	}

    /**
     * Function that show the teacher home page
     *
     * @return view
     */
	public function showHome()
	{
		return View::make('teacher.home')->with(
            array(
                'assignments' => AssignmentController::getLatestAssignments()
            )
        );
	}

    /**
     * Function that return the teacher profile view
     *
     * @return view
     */
	public function showProfile()
	{
		return View::make('teacher.profile')->with(
			array(
				'teacher' => Teacher::find(Auth::id()),
            )
        );
	}

    /**
     * Function that return the university teachers view
     *
     * @return view
     */
	public function showAllTeachersView ()
	{
		return View::make('university.show_all_teachers')->with(
			array(  
				'teachers' => $this->getTeachers(),
			)
  		);
	}

    /**
     * Function that add a new teacher to the collection and return to add_teacher view
     *
     * @return view
     */
	public function addTeacher()
	{
		$user = new User;
		$user->user = trim(strtolower(Input::get('email')));
		$user->password = Hash::make(Input::get('email'));
		$user->rank = "teacher";
		$user->last_activity = null;

		// Try to save, if not work, then redirect back with an error message
		try
		{
			$user->save();
		}
		catch(MongoDuplicateKeyException $e)
		{
			return Redirect::back()->withErrors(
				array( 
					'error' => Lang::get('register_student.email_duplicated')
				)
			);
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

		// Check for profile image, an then set to the teacher
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

    /**
     * Function that update the teacher data.
     *
     * @return view
     */
	public function update()
	{
		$teacher = Teacher::find(new MongoId(Input::get('_id')));
		$email = trim(strtolower(Input::get('email')));

		if(strcmp($email, $teacher->email) !== 0)
		{
			$user = User::first(['_id' => $teacher->_id]);
			$user->user = $email;

			// Try to save, if not work, then redirect back with an error message
			try
			{
				$user->save();
			}
			catch(MongoDuplicateKeyException $e)
			{
				return Redirect::back()->withErrors(
					array( 
						'error' => Lang::get('register_student.email_duplicated')
					)
				);
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

    /**
     * Function that update the teacher profile information include the password.
     *
     * @return view
     */
    public function updateTeacher()
    {
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
            {
                Auth::user()->password = Hash::make(Input::get('new_password'));
                Auth::user()->save();
        	}
        }

		// Check for teacher profile picture
        if(Input::hasFile('avatar_file'))
        {
            $data = Input::get('avatar_data');

            if(is_null($teacher->profile_image))
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

    /**
     * Function that return a teacher information array
     *
     * @return Array
     */
	public function find()
	{
		if(Request::ajax())
		{
			$teacher = Teacher::where('email', Input::get('email'))->first();
			
			return Response::json($teacher);
		}
	}

    /**
     * Function that unlink a section from a teacher
     *
     * @return void
     */
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

	public function showApprovalStudentView()
	{
		$pending = PendingEnrollment::where('teacher_id', Auth::id())->get();

		if(count($pending) > 0)
		{
			return View::make('teacher.approval_student')->with(
				array(
					'pending' => $pending,
					'stats' => MessageController::getStats(),
		 	 	)
		 	);
		}
		else
			return Redirect::to(Lang::get('routes.'.Auth::user()->rank));
	}

	public function showAddTeamleaderView()
	{
		$teacher = Teacher::find(Auth::id());
		$subjects = Subject::whereIn('_id', $teacher->subjects_id)->get();

		return View::make('teacher.add_teamleader')->with(
			array( 
				'subjects' => $subjects,
			 )
		);	
	}

	public function addTeamleader()
	{
		$aux = Input::get('teamleader');
		$teamleaders = array();
		$subject = Subject::find(Input::get('subject'));
		$section = $subject->sections()->find(Input::get('section'));
		
		foreach ($aux as $value) 
			array_push($teamleaders, new MongoId($value));

		if(isset($section->current_code))
		{
			$sectionCode = SectionCode::where('code', $section->current_code)->first();
			$sectionCode->push('teamleaders_id', $teamleaders, true);
				
			return Redirect::to(Lang::get('routes.add_teamleader'))->with('message', Lang::get('teacher_profile.success'));
		}
		else
			return Redirect::back()->withErrors(array( 'error' => Lang::get('teacher_profile.section_code_fail')));
	}

	public function showAllTeamleaderView()
	{
		$sectionCodes = SectionCode::where('teacher_id', Auth::id())->get();
		$subjects = array();

		foreach ($sectionCodes as $value)
			array_push($subjects, Subject::find($value->subject_id));

		return View::make('teacher.show_all_teamleader')->with(
			array( 
				'subjects' => $subjects,
			)
		);	
	}
}
