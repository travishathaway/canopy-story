@extends('layouts.app')

@section('content')
<div class="list-container container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h1>Survey</h1>
            <p>
                Thank you for signing up to tell your tree story. In order to help further
                the efforts of our research to see the ways trees shape our lives and communities,
                we kindly ask that you participate in this brief survey, so we may gain more
                information about you the story teller.
            </p>

            @if (session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            {{ Form::open(array('route' => 'survey.create')) }}
            {{ Form::hidden('id', $user['id'])}}

            <div class="form-group">
              {{ Form::label('year_born', 'What year were you born?')}}
              {{ Form::select('year_born', $year_born_choices, null,  ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
              {{ Form::label('gender', 'What is your gender?')}}
              {{ Form::select('gender', $gender_choices, null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
              {{ Form::label('race_ethnicity', 'What is your race/ethnicity?')}}
              {{ Form::select('race_ethnicity', $race_ethnicity_choices, null, ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
              {{ Form::label('home_zip_code', 'What is your home zip code?')}}
              {{ Form::text('home_zip_code', '', ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
              {{ Form::label('education', 'What is the highest level of education you have completed?')}}
              {{ Form::select('education', $education_choices, null, ['class' => 'form-control']) }}
            </div>

            <hr>

            <div class="row">
                <div class="col-xs-6">
                      <input type="submit" name="no_participate" 
                        class="col-xs-12 btn btn-success" value="I do not want to participate">
                </div>
                <div class="col-xs-6">
                      <input type="submit" name="participate" 
                        class="col-xs-12 btn btn-primary" value="Submit my answers">
                </div>
            </div>

            {{ Form::close()}}
        </div>
    </div>
</div>
@stop


