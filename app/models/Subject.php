<?php

use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class Subject extends Moloquent
{
	use SoftDeletingTrait;

	protected $collection = "subjects";
	protected $dates = ['deleted_at'];

	public function sections()
	{
		return $this->embedsMany('Section');
	}
}
