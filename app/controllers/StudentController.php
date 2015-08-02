<?php

class StudentController extends BaseController
{
	/**
    * Show the view on the navigator
    *
    * @return void
    */
    public function showHome()
    {
        return View::make('student.home')->with(
            array(
                'data' => array(
                    json_encode(array(
                        "id" => 1, 
                        "text" => 'Office itinerancy', 
                        "type" => 'gantt.config.types.project', 
                        "order" => 10, 
                        "progress" => 0.4, 
                        "open" => false
                    )),
                    json_encode(array(
                        "id" => 2, 
                        "text" => 'Office facing', 
                        "type" => 'gantt.config.types.project', 
                        "order" => 10, 
                        'progress' =>  0.6, 
                        "open" =>  true,
                        "parent" => 1, 
                        "start_date" => '02-04-2013', 
                        "duration" => 8, 
                    ))
                ),
                'links' => array(
                    json_encode(array(
                        "id" => 1, 
                        "source" => 1, 
                        "target" => 2, 
                        "type" => 1,
                    )),
                    json_encode(array(
                        "id" => 2, 
                        "source" => 2, 
                        "target" => 3, 
                        "type" => 0,
                    ))
                ),
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
            return Redirect::back()->withErrors(array( 'error' => Lang::get('register_student.email_duplicated')));
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
        $student->is_teamleader = false;
        $student->save();

        return Redirect::to('/')->with('message', Lang::get('register_student.register_true'));
    }

    public function showProfile()
    {
        return View::make('student.profile')->with(array('student' => Student::where('_id', '=', Auth::id())->first()));
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
        $student->phone=trim(strtolower(Input::get('phone')));
        $student->university_id=trim(Input::get('nip'));
        $student->cellphone=trim(strtolower(Input::get('cellphone')));


        if(strcmp($email, $student->email) !== 0) {

            Auth::user()->user = $email;

            try {

                Auth::user()->save();

            } catch (MongoDuplicateKeyException $e) {
                return Redirect::back()->withErrors(array('error' => Lang::get('register_student.email_duplicated')));
            }

            $flag = true;
            $student->email = $email;
        }


        if(Input::hasFile('photo'))
        {
            if($student->picture === null)
            {
                $file = Input::file('photo');
                $photoname = uniqid();
                $file->move(storage_path() . '/photos/imagesprofile', $photoname.'.'.$file->guessClientExtension());
                $image = Image::make(storage_path().'/photos/imagesprofile/'.$photoname.'.'.$file->guessClientExtension())->resize(140, 140)->save();
                $student->picture = '/photos/imagesprofile/' . $photoname.'.'.$file->guessClientExtension();
            }
            else
            {
                $file = Input::file('photo')->getRealPath();
                $image = Image::make($file)->resize(140, 140)->save(storage_path().$student->picture);
            }
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
            $student = Student::where('email', '=', Input::get('email'))->first();
            return Response::json($student);
        }
    }
}


