<?php
/**
 * Created by PhpStorm.
 * User: narcisonunez
 * Date: 02/06/2015
 * Time: 20:54
 */

class UniversityController extends BaseController
{
    public function showIndex()
    {
        return View::make('university.university_index')->with(array( 'subjects' => 'Invalid Email or Password',
                                                                        'professors' => 'Mundo'));
    }

    public function showProfile()
    {
        return View::make('university.profile');
    }
} 