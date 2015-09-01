<?php

class Gantt extends Moloquent
{
	protected $collection = "gantts";

	/**
     * Embeds relation with DetailsGantt Collection
     * 
     * @return Array(Section)
     */
	public function details_gantts()
	{
		return $this->embedsMany('DetailsGantt');
	}
}
