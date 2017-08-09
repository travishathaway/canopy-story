<?php

namespace App\Forms;

class SurveyForm {

    /**
     * Choices for age range field
     */
    public $age_range_choices = [
        'en' => [
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
        ],
        'es' => [
            '' => '',
            'under_18' => 'Menores de 18 años',
            '18_24' => '18 - 24',
            '25_34' => '25 - 34',
            '35_44' => '35 - 44',
            '45_54' => '45 - 54',
            '55_64' => '55 - 64',
            '65_74' => '65 - 74',
            '75_84' => '75 - 84',
            '85_or_older' => 'Más de 85 años'
        ]
    ];

    /**
     * Choices for gender field
     */
    public $gender_choices = [
        'en' => [
            '' => '',
            'male' => 'Male',
            'female' => 'Female',
            'trans_male' => 'Trans Male',
            'trans_female' => 'Trans Female',
            'genderqueer_androgynous' => 'Genderqueer/Androgynous',
            'other' => 'Other'
        ],
        'es' => [
            '' => '',
            'male' => 'Masculino',
            'female' => 'Femenino',
            'trans_male' => 'Hombre transgénero',
            'trans_female' => 'Mujer transgénero',
            'genderqueer_androgynous' => ' Genderqueer/Género neutral',
            'other' => 'Otro'
        ]
    ];

    /**
     * Choices for race/ethnicity field
     */
    public $race_ethnicity_choices = [
        'en' => [
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
            'other' => 'Other',
        ],
        'es' => [
            '' => '',
            'white' => 'Caucásico',
            'black_or_african america' => 'Negro o afroamericano',
            'alaska_native' => 'Nativo de Alaska',
            'american_indian_native_american' => 'Nativo americano',
            'south_asian' => 'Sur asiático',
            'east_asian' => 'Asiático del este',
            'southeast_asian' => 'Sudoeste asiático',
            'west_asian' => 'Asiático occidental',
            'middle_eastern' => 'Medio este',
            'african' => 'Africano',
            'native_hawaiian_or_pacific_islander' => 'Nativo hawaiano o isleño pacifico',
            'hispanic_latino' => 'Hispano o latino',
            'slavic_or_eastern_european' => 'Eslavo o europeo del este',
            'other' => 'Otro',
        ]
    ];

    /**
     * Choices for education field
     */
    public $education_choices = [
        'en' => [
            '' => '',
            'less_than_high_school' => 'Less Than High School',
            'high_school' => 'High School',
            'some_college' => 'Some College',
            'bachelors_degree' => "Bachelor's Degree",
            'graduate_or_professional_degree' => "Graduate and/or Professional Degree",
        ],
        'es' => [
            '' => '',
            'less_than_high_school' => 'Menos que la escuela secundaria',
            'high_school' => 'Escuela secundaria',
            'some_college' => 'Alguna educación superior',
            'bachelors_degree' => "Licenciatura",
            'graduate_or_professional_degree' => "Titulo graduado o profesional",
        ]
    ];

    /**
     * Creates an instance of SurveyForm
     *
     * @param $locale string (en|es) language of choices to return
     */
    public function __construct($locale='en')
    {
        $this->locale = $locale;
    }

    public function getFieldChoices($field)
    {
        if(isset($this->$field)){
            return $this->$field[$this->locale];
        }
    }
}

?>
