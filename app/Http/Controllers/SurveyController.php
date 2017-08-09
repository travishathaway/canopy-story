<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Forms\SurveyForm;

class SurveyController extends Controller
{
    public $survey_fields = array(
        'age_range',
        'gender',
        'race_ethnicity',
        'home_zip_code',
        'education'
    );

    /**
     * Display the survey form
     */
    public function get(Request $request)
    {
        $survey_form = new SurveyForm(\App::getLocale());

        $view_vars = array();

        foreach($this->survey_fields as $field){
            $key = $field . '_choices';
            $choices = $survey_form->getFieldChoices($key);

            if($choices){
                $view_vars[$key] = $choices;
            }
        }

        $view_vars['user'] = $request->user();

        return view('survey.create', $view_vars);
    }

    /**
     * Updates the user model with answers from the survey
     */
    public function create(Request $request)
    {
        $input = $request->all();

        if(!empty($input['id'])){
            $user = User::find($input['id']);

            if($user){
                if(!empty($input['participate'])){
                    $user->survey_status = 'complete';

                    foreach($this->survey_fields as $field){
                        $user->$field = $input[$field] ? $input[$field] : null;
                    }
                } else {
                    $user->survey_status = 'no participate';
                }

                $user->save();

                return redirect('/')->with('success', 'Thank you');
            } else {
                # user not found with provided ID, something is amiss
                return redirect('survey')->with('danger', 'User ID not found');
            }
        } else {
            # user id not provided, something is amiss
            return redirect('survey')->with('danger', 'User ID not provided');
        }
    }
}
