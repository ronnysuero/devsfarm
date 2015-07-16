<?php

class University extends Moloquent
{
    protected $collection = "universities";

    public function messages()
	{
		return $this->embedsMany('Message');
	}
}
