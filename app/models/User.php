<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;

class User extends MongoLid implements UserInterface
{
	use UserTrait, RemindableTrait;

	/**
		* The database name used by the model.
		*
		* @var string
		*/
	protected $database = 'student';
	/**
		* The database collection used by the model.
		*
		* @var string
		*/
	protected $collection = 'users';

	/**
		* The attributes excluded from the model's JSON form.
		*
		* @var array
		*/
	protected $hidden = array('password');

	/**
		* Get the unique identifier for the user.
		*
		* @return mixed
		*/
	public function getAuthIdentifier()
	{
			return $this->_id;
	}

	/**
		* Get the password for the user.
		*
		* @return string
		*/
	public function getAuthPassword()
	{
			return $this->password;
	}

}
