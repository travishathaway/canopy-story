@extends('layouts.app')

@section('script')
<script>
$(document).ready(function(){
  $('#participate-btn').on('click', function(){
    $('#take-survey').hide();
    $('#survey').removeClass('hidden');
  });

  $('#language-choice').on('click', function(){
    window.location = '?lang='+$(this).data('value');
  });
});
</script>
@stop

@section('content')
<div class="list-container container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="pull-right">
                  @if(\App::getLocale() === 'en')
                    <button type="button" class="btn btn-default btn-sm" id="language-choice" data-value="es">
                      <span class="text-muted"><span class="lang-sm lang-lbl" lang="es"></span></span>
                    </button>
                  @else
                    <button type="button" class="btn btn-default btn-sm" id="language-choice" data-value="en"> 
                      <span class="text-muted"><span class="lang-sm lang-lbl" lang="en"></span></span>
                    </button>
                  @endif
            </div>
            <h1>@lang('survey.title')</h1>
            <p>
              @lang('survey.intro')
            </p>
            
            @if (session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            <hr>
            {{ Form::open(array('route' => 'survey.create')) }}
            <div id="take-survey">
                <div class="row">
                    <div class="col-xs-6">
                          <input type="submit" name="no_participate" 
                            class="col-xs-12 btn btn-danger" value="@lang('survey.no_button')">
                    </div>
                    <div class="col-xs-6">
                        <button type="button" id="participate-btn" class="col-xs-12 btn btn-success">
                            @lang('survey.yes_button')
                        </button>
                    </div>
                </div>
                <br>
            </div>

            <div id="survey" class="hidden">
                <p><i>@lang('survey.disclaimer')</i></p>
                {{ Form::hidden('id', $user['id'])}}

                <div class="form-group">
                  {{ Form::label('age_range', __('survey.age_queston'))}}
                  {{ Form::select('age_range', $age_range_choices, null,  ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                  {{ Form::label('gender', __('survey.gender_question'))}}
                  {{ Form::select('gender', $gender_choices, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                  {{ Form::label('race_ethnicity', __('survey.race_question'))}}
                  {{ Form::select('race_ethnicity', $race_ethnicity_choices, null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                  {{ Form::label('home_zip_code', __('survey.zipcode_question'))}}
                  {{ Form::text('home_zip_code', '', ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                  {{ Form::label('education', __('survey.education_question'))}}
                  {{ Form::select('education', $education_choices, null, ['class' => 'form-control']) }}
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6 col-xs-12">
                          <input type="submit" name="participate" 
                            class="col-xs-12 btn btn-primary" value="@lang('survey.submit_button')">
                    </div>
                </div>
            </div>

            {{ Form::close()}}
        </div>
    </div>
</div>
@stop


