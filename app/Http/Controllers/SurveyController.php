<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SurveyController extends Controller
{
    public $survey_fields = array(
        'year_born',
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
        $year_born_choices = array_reverse(range(1917, 2016));
        # This is how we add a default empty value
        array_unshift($year_born_choices, '');
        # This makes the array index the same as the value
        $year_born_choices = array_combine($year_born_choices, $year_born_choices);

        $gender_choices = [
            '' => '',
            'male' => 'Male',
            'female' => 'Female',
            'non_binary' => 'Non-binary/Third Gender',
            'not_disclosed' => 'Prefer not to say'
        ];

        $race_ethnicity_choices = [
            '' => '',
            'white' => 'White',
            'black or african america' => 'Black or African American',
            'american indian and alaska native' => 'American Indian and Alaska Native',
            'asian' => 'Asian',
            'arab' => 'Arabic',
            'hispanic latino' => 'Hispanic/Latino',
            'native hawaiian or pacific islander' => 'Native Hawaiian or Pacific Islander',
            'other' => 'Other',
            'two or more' => 'Two or More'
        ];

        $education_choices = [
            '' => '',
            'high school' => 'High School/GED',
            'vocational training' => 'Vocational Training',
            'associates' => 'Associates',
            'bachelors' => 'Bachelors',
            'masters' => 'Masters',
            'doctorate' => 'Doctorate',
            'none' => 'None',
        ];


        return view('survey.create', [
            'year_born_choices' => $year_born_choices,
            'gender_choices' => $gender_choices,
            'race_ethnicity_choices' => $race_ethnicity_choices,
            'education_choices' => $education_choices,
            'user' => $request->user()
        ]);
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
                } elseif(!empty($input['no_participate'])) {
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
