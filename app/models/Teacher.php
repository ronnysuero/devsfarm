<?php

use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class Teacher extends Moloquent
{
	use SoftDeletingTrait;

	protected $collection = "teachers";
	protected $dates = ['deleted_at'];
	
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
