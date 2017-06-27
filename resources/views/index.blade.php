@extends('layouts.map')

@section('title', 'Canopy Stories')

@section('content')
    <div id="map"></div>
    <div id="tutorial-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" 
      aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h1 class="modal-title text-center" >{{ config('app.name')}}</h1>
          </div>
          <div class="modal-body">
            <iframe	id="tutorial-iframe" src="https://climatecope.research.pdx.edu/csSS/csSS.php?title={{ config('app.name') }}"></iframe>
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
<script>
var base_dir = '{{ config('app.url')}}';
@if(Auth::check())
var logged_in = true;
@else
  var logged_in = false;
@endif

function checkLogin(){
    try{
        if(logged_in !== true){
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
<script src="{{ asset('js/popup.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/resumable.js') }}" type="text/javascript"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
@endsection
