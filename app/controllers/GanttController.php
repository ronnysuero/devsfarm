<?php

class GanttController extends BaseController
{	
	/**
	 * search all the data belonging to the user to generate a Gantt chart
	 * 
	 * @param  $subject_id MongoId
	 * @param  $section_id MongoId
	 * @return Array(Gantt)
	 */
	public function getData($subject_id, $section_id)
	{
		return Gantt::where('user_id', Auth::id())
					  ->where('subject_id', $subject_id)
					  ->where('section_id', $section_id)
					  ->select(array('id', 'text', 'type', 
					  				 'start_date', 'duration', 
					  				 'order', 'progress', 'parent', 
					  				 'open'))->get();
	}
	
	/**
	 * search all the link belonging to the user to generate a Gantt chart
	 * 
	 * @param  $subject_id MongoId
	 * @param  $section_id MongoId
	 * @return Array(Gantt)
	 */
	public function getLink($subject_id, $section_id)
	{
		return Gantt::where('user_id', Auth::id())
					  ->where('subject_id', $subject_id)
					  ->where('section_id', $section_id)
					  ->select(array('id', 'source', 'target', 'type_link'))->get();
	}

	/**
	 *	Remove quotes for a type word
	 * 
	 * @param  $string String
	 * @return String
	 */
	public static function removeQuotes($string)
	{
		$pos = strpos($string, 'type');

		if($pos !== false)
		{
			$first = substr($string, 0, $pos + 6);
			$word = substr($string, $pos + 6);
			$word = substr($word, 1, strlen($word));
			$word = substr($word, 0, strpos($word, '"'));
			$pos = strpos($string, $word);
			$end = substr($string, $pos + strlen($word) + 1, strlen($string));
		}
		
		return $first.$word.$end;
	}
}