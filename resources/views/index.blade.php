@extends('layouts.map')

@section('title', 'Canopy Stories')

@section('content')
    <div id="map"></div>
    <div id="tutorial-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" 
      aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            @if(\App::getLocale() === 'en')
              <a href="?lang=es" type="button" 
                class="btn btn-default btn-sm" id="language-choice">
                <span class="text-muted"><span class="lang-sm lang-lbl" lang="es"></span></span>
              </a>
            @else
              <a href="?lang=en" type="button" 
                class="btn btn-default btn-sm" id="language-choice">
                <span class="text-muted"><span class="lang-sm lang-lbl" lang="en"></span></span>
              </a>
            @endif
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h1 class="modal-title text-center" >{{ config('app.name')}}</h1>
          </div>
          <div class="modal-body">
            <iframe	id="tutorial-iframe" src="{{url('help')}}?lang={{\App::getLocale()}}"></iframe>
          </div>
          <div class="modal-footer-center">
            <button type="button" class="btn btn-primary" 
              data-dismiss="modal" aria-label="Close">
              Tell My Story
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="destroyer" id="copyR">
      <div id="internal">
        <div id="header">
        </div>
        <div id="main-text">
        </div>
        <div id="footer">
            <button id="tell-my-story" onclick="destroyButton()">Tell My Story</button>
        </div>
      </div>
    </div>

    @include('partials.legend')
@endsection

@section('scripts')
@parent
<script>
var base_dir = '{{ config('app.url') }}';
var share_email = '{{ config('app.share_email') }}'
@if(Auth::check())
  var logged_in = true;
@else
  var logged_in = false;
@endif

@if($has_visited)
  var has_visited = true;
@else
  var has_visited = false;
@endif

var upload_file_location = '{{ elixir('js/upload.js') }}';

function checkLogin(){
    try{
        if(has_visited === false){
          $('#tutorial-modal').modal('show');
        } else {
          $('#legend').css({'visibility': 'visible'});
        }
    } catch(ReferenceError){
        setTimeout(function(){
            checkLogin();
        }, 250);
    }
}

checkLogin();

var updated = [];
var updated_trees = [];

$('#tutorial-modal').on('hide.bs.modal', function(){
  $('#legend').css({'visibility': 'visible'});
});

</script>
<script src="{{ elixir('js/map.js') }}" type="text/javascript"></script>
@endsection
