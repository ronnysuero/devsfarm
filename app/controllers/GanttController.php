<?php

class GanttController extends BaseController
{	
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
			
			return $first.$word.$end;
		}
		else
			return $string;
	}

	public static function getDataGantt($groups)
	{
	 	$arrayData = array();
	 	$arrayLink = array();

	 	$count = count($groups) + 1;
		
		foreach ($groups as $item => $group) 
		{
			$dataGroup = array();
			$dataGroup['id'] = ($item + 1);
			$dataGroup['text'] = $group->name;
			$dataGroup['type'] = 'gantt.config.types.project';
			$dataGroup['open'] = true;

			$dataLink = array();
			$dataLink['id'] = ($item + 1);
			$dataLink['source'] = ($item + 1);
			$dataLink['target'] = $count;

			$assignments = Assignment::where('group_id', new MongoId($group->_id))->orderBy('date_assigned', 'asc')->get();
			$progress = array();

			foreach ($assignments as $index => $assignment) 
			{
				if($index == 0)
				{
					$dataLink['type'] = 1;
					array_push($arrayLink, json_encode($dataLink));
				}

				$dataAssignment = array();
				$dataAssignment['id'] = $count;
				$dataAssignment['text'] = $assignment->description;
				$dataAssignment['start_date'] = date('d-m-Y', $assignment->date_assigned->sec);
				$dataAssignment['parent'] = ($item + 1);
				$dataAssignment['open'] = true;

				$dataLink = array();
				$dataLink['id'] = $count;
				$dataLink['source'] = $count;
				$dataLink['target'] = ($count + 1);
				$dataLink['type'] = 0;

				array_push($arrayLink, json_encode($dataLink));

				$pg = (strcasecmp($assignment->state, 'c') === 0) ? 1 : 0;
				$dataAssignment['progress'] = $pg;
				
				if($pg === 1)
					$dataAssignment['type'] = 'gantt.config.types.milestone';
				
				array_push($progress, $pg);

				$date_assigned = new DateTime(date('Y-m-d', $assignment->date_assigned->sec));
				$deadline = new DateTime(date('Y-m-d', $assignment->deadline->sec));
				$date_assigned = $date_assigned->diff($deadline);

				$dataAssignment['duration'] = $date_assigned->days;
				array_push($arrayData, json_encode($dataAssignment));
				$count += 1;
			}
			
			$dataGroup['progress'] = (count($progress) > 0) ? array_sum($progress)/count($progress) : 0;
			array_push($arrayData, json_encode($dataGroup));
		}

		return array('data' => $arrayData, 'link' => $arrayLink);
	}
}