<?php

use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class Subject extends Moloquent
{
	use SoftDeletingTrait;

	protected $collection = "subjects";
	protected $dates = ['deleted_at'];

	/**
     * Embeds relation with Section Collection
     * 
     * @return Array(Section)
     */
	public function sections()
	{
		return $this->embedsMany('Section');
	}
}
