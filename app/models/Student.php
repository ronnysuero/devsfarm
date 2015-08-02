<?php

class Student extends Moloquent
{
	protected $collection = "students";

	/**
     * Embeds relation with Message Collection
     * 
     * @return Array(Message)
     */
	public function messages()
	{
		return $this->embedsMany('Message');
	}
}
