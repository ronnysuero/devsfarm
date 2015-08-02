<?php

class University extends Moloquent
{
	/**
	 * University Collection
	 * 
	 * @var string
	 */
    protected $collection = "universities";

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
