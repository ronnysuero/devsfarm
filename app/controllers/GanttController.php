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

	public static function getDataGantt($groups)
	{
	 	$arrayData = array();
	 	$count = count($groups) + 1;

	// 	{"id":1, "text":"Office itinerancy", 
	// 	"type":gantt.config.types.project, 
	// 	"order":"10", progress: 0.4, open: false},
		
		foreach ($groups as $item => $group) 
		{
			$dataGroup = array();
			$dataGroup['id'] = ($item + 1);
			$dataGroup['text'] = $group->project_name;
			$dataGroup['type'] = 'gantt.config.types.project';
			$dataGroup['open'] = true;
				
			$assignments = Assignment::where('group_id', new MongoId($group->_id));
			$progress = array();

			// {"id":5, "text":"Interior office", 
			// "start_date":"02-04-2013", "duration":"7", 
			// "order":"3", "parent":"2", progress: 0.6, open: true},
			
			foreach ($assignments as $assignment) 
			{
				$dataAssignment = array();
				$dataAssignment['id'] = $count;
				$dataAssignment['text'] = $assignment->description;
				$dataAssignment['start_date'] = date('d-m-Y', $assignment->date_assigned->sec);
				$dataAssignment['parent'] = ($item + 1);
				$dataAssignment['open'] = true;

				$pg = (strcasecmp($assignment->state, 'c') === 0) ? 1 : 0;
				$dataAssignment['progress'] = $pg;
				array_push($progress, $pg);

				$date_assigned = new DateTime(date('Y-m-d', $assignment->date_assigned->sec));
				$deadline = new DateTime(date('Y-m-d', $assignment->deadline->sec));
				$date_assigned = $date_assigned->diff($deadline);

				$dataAssignment['duration'] = $date_assigned->days;
				array_push($arrayData, $dataAssignment);
				$count += 1;
			}

			array_push($arrayData, $dataGroup);
			//$dataGroup['progress'] = array_sum($progress)/count($progress);
		}

		return $arrayData;
	}
}