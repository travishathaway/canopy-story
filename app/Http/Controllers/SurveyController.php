<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $lang = $request->input('lang');

        $supported_langs = array(
          'es' => 'Español', 
          'en' => 'English'
        );

        if( 
          $lang !== \App::getLocale() and 
          in_array(strtolower($lang), array_keys($supported_langs))
        ) {
            \App::setLocale($lang);
        }

        $age_range_choices = [
            '' => '',
            'under_18' => 'Under 18',
            '18_24' => '18 - 24',
            '25_34' => '25 - 34',
            '35_44' => '35 - 44',
            '45_54' => '45 - 54',
            '55_64' => '55 - 64',
            '65_74' => '65 - 74',
            '75_84' => '75 - 84',
            '85_or_older' => '85 or older'
        ];

        $gender_choices = [
            '' => '',
            'male' => 'Male',
            'female' => 'Female',
            'trans_male' => 'Trans Male',
            'trans_female' => 'Trans Female',
            'genderqueer_androgynous' => 'Genderqueer/Androgynous',
            'other' => 'Other'
        ];

        $race_ethnicity_choices = [
            '' => '',
            'white' => 'White',
            'black_or_african america' => 'Black or African American',
            'alaska_native' => 'Alaska Native',
            'american_indian_native_american' => 'American Indian/Native American',
            'south_asian' => 'South Asian',
            'east_asian' => 'East Asian',
            'southeast_asian' => 'South East Asian',
            'west_asian' => 'West Asian',
            'middle_eastern' => 'Middle Eastern',
            'african' => 'African',
            'native_hawaiian_or_pacific_islander' => 'Native Hawaiian or Pacific Islander',
            'hispanic_latino' => 'Hispanic/Latino',
            'slavic_or_eastern_european' => 'Slavic or Eastern European',
            'white' => 'White',
            'black_or_african_american' => 'Black or African American',
            'other' => 'Other',
        ];

        $education_choices = [
            '' => '',
            'less_than_high_school' => 'Less Than High School',
            'high_school' => 'High School',
            'some_college' => 'Some College',
            'bachelors_degree' => "Bachelor's Degree",
            'graduate_or_professional_degree' => "Graduate and/or Professional Degree",
        ];


        return view('survey.create', [
            'age_range_choices' => $age_range_choices,
            'gender_choices' => $gender_choices,
            'race_ethnicity_choices' => $race_ethnicity_choices,
            'education_choices' => $education_choices,
            'user' => $request->user(),
            'languages' => $supported_langs
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
