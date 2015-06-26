<?php

class SectionController extends BaseController
{
	public function showView()
	{
    	return View::make('university.add_section')->with(array('subjects' => Subject::where('university_id', '=', Auth::id())->get()));
  	}

  	public function showAllSectionsView()
    {
    	$subjects = Subject::where('university_id', '=', Auth::id())->get();
      	return View::make('university.show_all_sections')->with(array( 'subjects' => $subjects));
    }

    public function find()
    {
      	if(Request::ajax())
      	{
      		if(Input::get('_id') !== null)
      		{
      			$subject = Subject::where('_id', '=', Input::get('_id'))->where('university_id', '=', Auth::id())->first();
        	
       	 		if($subject !== null)
        			return Response::json(array('subject' => $subject, 'sections' => $subject->sections));
    		
      		}
      		else if (Input::get('code') !== null && Input::get('subject_id') !== null)
      		{
      			$subject = Subject::where('_id', '=', Input::get('subject_id'))->where('university_id', '=', Auth::id())->first();
        	
       	 		if($subject !== null)
       	 		{
       	 			foreach ($subject->sections as $section) 
       	 			{
       	 				if($section->code === Input::get('code'))
       	 					return Response::json(array('section' => $section, 'subject_id' => $subject->_id));
       	 			}
       	 		}
        	}
      	}
    }
    
    public function addSection()
  	{
	    $subject = Subject::where('_id', '=', new MongoId(Input::get('_id')))->first();

	    $sections = explode(',', Input::get('section'));

	    foreach($sections as $section)
	    {
	      $sect = new Section;
	      $sect->code = strtoupper(trim($section));
	      $sect->is_free = true;
	      $subject->sections()->associate($sect);
	    }

    	$subject->save();
	    return Redirect::to(Lang::get('routes.add_section'))->with('message', Lang::get('add_section.success'));
	}	

	public function update()
  	{  
  		$subject = Subject::where('_id', '=', new MongoId(Input::get('subject_id')))->first();

	    foreach ($subject->sections as $section) 
		{
       		if($section->_id === Input::get('_id'))
       		{	
       			$section->code = Input::get('section_code');
       			$section->save(); 
       		}
       	}
	    return Redirect::to(Lang::get('routes.show_all_sections'))->with('message', Lang::get('university_profile.update_message'));  
	}
}