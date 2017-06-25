@extends('layouts.map')

@section('title', 'Canopy Stories')

@section('content')
    <div id="map"></div>
    <div class="destroyer" id="copyR">
      <div id="internal">
        <div id="header">
          <h1>{{ config('app.name')}}</h1>
        </div>
        <div id="main-text">
          <iframe	src="https://climatecope.research.pdx.edu/csSS/csSS.php?title={{ config('app.name') }}"></iframe>
        </div>
        <div id="footer">
          <button id="tell-my-story" onclick="destroyButton()">Tell My Story</button>
        </div>
      </div>
    </div>

    @include('partials.legend')
@endsection

@section('scripts')
<script>
var base_dir = '{{ config('app.url')}}';
@if(Auth::check())
var logged_in = true;
@else
  var logged_in = false;
@endif

function checkLogin(){
    try{
        if(logged_in === true){
            destroyButton();
        } else {
            $('.destroyer').css('visibility', 'visible');
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

</script>
<script src="{{ asset('js/popup.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/resumable.js') }}" type="text/javascript"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
@endsection
