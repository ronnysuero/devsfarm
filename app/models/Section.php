<?php

use Jenssegers\Mongodb\Eloquent\SoftDeletingTrait;

class Section extends Moloquent
{
	use SoftDeletingTrait;

	protected $collection = "sections";
	protected $dates = ['deleted_at'];
}
