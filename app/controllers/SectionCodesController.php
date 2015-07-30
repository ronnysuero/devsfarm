<?php

class SectionCodesController extends BaseController{

    public function getInitialLetters($word){
        $words = explode(' ', $word);
        $acronym = '';

        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        return $acronym;
    }

    public function addSectionCode(){

        $section_code = new SectionCodes;

        $teacher = Teacher::find(Auth::Id());
        $subject_id = Input::get('subject_id');
        $section_id = Input::get('section_id');
        $current_period = Input::get('current_period');

        $section_code->teacher_id = $teacher->_id;
        $section_code->subject_id = $subject_id;
        $section_code->section_id = $section_id;
        $section_code->current_period = $current_period;


        $subject = Subject::find($subject_id);
        $section = $subject->sections()->find($section_id);


        $code =  $this->getInitialLetters($subject->name) .'-'. $section->code .'-'. $current_period;
        $section_code->code = $code;

        try
        {
            $section_code->save();
        }
        catch(MongoDuplicateKeyException $e)
        {
            return Redirect::back()->withErrors(array( 'error' => 'Codigo Duplicado'));
        }

        return Redirect::to(Lang::get('routes.section_codes'))->with('message', 'Se ha registrado super chevere');
    }
}