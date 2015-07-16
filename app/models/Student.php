<?php

class Student extends Moloquent
{
	protected $collection = "students";

	public function messages()
	{
		return $this->embedsMany('Message');
	}
}
