<?php

class Subject extends Moloquent
{
	protected $collection = "subjects";

	public function sections()
	{
		return $this->embedsMany('Section');
	}
}
