<?php

use Helpers\CropImage\CropImage;

class StudentController extends BaseController
{
	/**
	* Show the view on the navigator
	*
	* @return void
	*/
	public function showHome()
	{
		$groups = Group::whereIn('students_id', array(Auth::id()))->get();

		return View::make('student.home')->with(
			array(
				'data' => GanttController::getDataGantt($groups),
				//'data' => array(
					// json_encode(array(
					// 	"id" => 2, 
					// 	"text" => 'Office facing', 
					// 	"type" => 'gantt.config.types.project', 
					// 	//"order" => 10, 
					// 	'progress' =>  0, 
					// 	"open" =>  true,
					// 	"parent" => 1, 
					// 	"start_date" => '02-04-2013', 
					// 	"duration" => 0, 
					// )),
					// json_encode(array(
					// 	"id" => 1, 
					// 	"text" => 'Office itinerancy', 
					// 	"type" => 'gantt.config.types.project', 
					// 	//"order" => 10, 
					// 	"progress" => 0, 
					// 	"open" => true
					// ))
				//),
				'links' => array(
					// json_encode(array(
					// 	"id" => 1231, 
					// 	"source" => 1, 
					// 	"target" => 2, 
					// 	"type" => 1,
					// )),
					// json_encode(array(
					// 	"id" => 2123, 
					// 	"source" => 2, 
					// 	"target" => 3, 
					// 	"type" => 0,
					// ))
				),
				'groups' => $groups,
				'stats' => MessageController::getStats(),
			)
		);
	}

	public function registerStudent()
	{
		$user = new User;
		$user->user = trim(strtolower(Input::get('guest_email')));
		$user->password = Hash::make(Input::get('guest_password'));
		$user->rank = "student";
		$user->last_activity = null;

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

		$student = new Student;
		$student->_id = $user->_id;
		$student->name = ucfirst(trim(Input::get('guest_name')));
		$student->last_name = ucfirst(trim(Input::get('guest_lastname')));
		$student->id_number = trim(Input::get('guest_id'));
		$student->email = trim(strtolower(Input::get('guest_email')));
		$student->genre = strtolower(trim(Input::get('guest_genre')));
		$student->has_a_job = strtolower(trim(Input::get('guest_job')));
		$student->profile_image = null;
		$student->save();

		return Redirect::to('/')->with('message', Lang::get('register_student.register_true'));
	}

	public function showProfile()
	{
		return View::make('student.profile')->with(
			array(
				'student' => Student::find(Auth::id()), 
				'stats' => MessageController::getStats(),
			)
		);
	}

	public function updateStudent()
	{
		$flag = false;
		$student=Student::find(Auth::id());
		$student->name = ucfirst(trim(Input::get('name')));
		$student->last_name = ucfirst(trim(Input::get('last_name')));
		$student->genre = strtolower(trim(Input::get('genre')));
		$student->has_a_job = strtolower(trim(Input::get('job')));
		$email = trim(strtolower(Input::get('email')));
		$student->university_id = trim(Input::get('nip'));

		if(strcmp($email, $student->email) !== 0) 
		{
			Auth::user()->user = $email;

			try 
			{
				Auth::user()->save();
			} 
			catch (MongoDuplicateKeyException $e) 
			{
				return Redirect::back()->withErrors(
					array(
						'error' => Lang::get('register_student.email_duplicated')
					)
				);
			}

			$flag = true;
			$student->email = $email;
		}

		if(Input::hasFile('avatar_file'))
		{
			$data = Input::get('avatar_data');

			if(is_null($student->profile_image))
			{
				$image = new CropImage(null, $data, $_FILES['avatar_file']);
				$student->profile_image = $image->getURL();
			}
			else
				new CropImage($student->profile_image, $data, $_FILES['avatar_file']);
		}

		$student->save();

		if($flag)
		{
			Auth::logout();
			return Redirect::to('/')->with('message', Lang::get('student_profile.relogin'));
		}
		else
			return Redirect::to(Lang::get('routes.student_profile'))->with('message', Lang::get('student_profile.update_true'));
	}

	public function find()
	{
		if(Request::ajax())
		{	
			if(!is_null(Input::get('section')) && !is_null(Input::get('subject')))
			{
				$section = Subject::find(Input::get('subject'))->sections()->find(Input::get('section'));

				if(isset($section->current_code))
				{
					$sectionCode = SectionCode::where('code', $section->current_code)->first();
					
					$students = Student::whereIn('_id', $sectionCode->students_id)
									   ->whereNotIn('_id', $sectionCode->teamleaders_id)
									   ->orderBy('id_number', 'asc')->get();
					
					$code = (count($students) > 0) ? '00' : '99';

					return Response::json(array('students' => $students, 'code' => $code));
				}
				else 
					return Response::json("");
			}
			else if(!is_null(Input::get('id')))
				return Response::json(Student::find(Input::get('id')));
		}
	}

	public function showApprovalGroupView()
	{
		$pending = PendingGroup::where('teamleader_id', Auth::id())->get();
		
		if(count($pending) > 0)
		{
			return View::make('student.approval_group')->with(
				array(
					'pending' => $pending,
					'stats' => MessageController::getStats(),
		 	 	)
		 	);
		}
		else
			return Redirect::to(Lang::get('routes.'.Auth::user()->rank));
	}
}
