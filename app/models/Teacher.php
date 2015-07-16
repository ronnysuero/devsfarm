<?php

class Teacher extends Moloquent
{
	protected $collection = "teachers";

	public function messages()
	{
		return $this->embedsMany('Message');
	}
}
