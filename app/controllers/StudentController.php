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
        $group = Group::where('student_id', '=', Auth::id())->get();

        return View::make('student.home');
    }

    /**
     * Show the view on the navigator
     *
     * @return void
     */
    public function showRegisterView()
    {
        return View::make('student.register');
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
        $student->university_id= trim(Input::get('guest_id'));
        $student->email = trim(strtolower(Input::get('guest_email')));
        $student->genre = strtolower(trim(Input::get('guest_genre')));
        $student->has_a_job = strtolower(trim(Input::get('guest_job')));
        $student->is_teamleader = false;
        $student->messages_id = array();
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


