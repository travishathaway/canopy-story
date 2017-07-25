<?php

namespace Tests\Feature;

use App\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SurveyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test to make sure this page is login protected
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = factory(User::class)->create();
        $response = $this->get('/survey');

        # Not Logged in
        $response->assertStatus(302);

        # Logged in
        $response = $this->actingAs($user)->get('/survey');

        $response->assertStatus(200);
    }

    /**
     * Tests to make sure that the survey form updates the user
     * model accordingly when they do not participate
     *
     * @return void
     */
    public function testSurveySubmissionNoParticipate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/survey', [
            'age_range' => 'under_18',
            'id' => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/');

        $user = User::find($user->id);
        $this->assertEquals('no participate', $user->survey_status);
        $this->assertEquals(null, $user->age_range);
        $this->assertEquals(null, $user->gender);
        $this->assertEquals(null, $user->race_ethnicity);
        $this->assertEquals(null, $user->home_zip_code);
        $this->assertEquals(null, $user->education);
    }

    /**
     * Tests to make sure that the survey form updates the user
     * model accordingly when they do participate
     *
     * @return void
     */
    public function testSurveySubmissionParticipate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/survey', [
            'age_range' => '18_24',
            'gender' => 'male',
            'race_ethnicity' => 'white',
            'home_zip_code' => '12345',
            'education' => 'Masters',
            'participate' => 'Submit',
            'id' => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/');

        $user = User::find($user->id);
        $this->assertEquals('complete', $user->survey_status);
        $this->assertEquals('18_24', $user->age_range);
        $this->assertEquals('male', $user->gender);
        $this->assertEquals('white', $user->race_ethnicity);
        $this->assertEquals('12345', $user->home_zip_code);
        $this->assertEquals('Masters', $user->education);
    }

    /**
     * Tests to make sure that the survey form updates the user
     * model accordingly when they do participate
     *
     * @return void
     */
    public function testSurveySubmissionPartialParticipate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/survey', [
            'age_range' => '75_84',
            'gender' => '',
            'race_ethnicity' => 'white',
            'home_zip_code' => '',
            'education' => 'Masters',
            'participate' => 'Submit',
            'id' => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionMissing('danger');
        $response->assertRedirect('/');

        $user = User::find($user->id);
        $this->assertEquals('complete', $user->survey_status);
        $this->assertEquals('75_84', $user->age_range);
        $this->assertEquals(null, $user->gender);
        $this->assertEquals('white', $user->race_ethnicity);
        $this->assertEquals(null, $user->home_zip_code);
        $this->assertEquals('Masters', $user->education);
    }
}

