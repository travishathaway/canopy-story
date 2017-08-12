@extends('layouts.map')

@section('styles')
@parent
<style>
html, body, #map {
  height: 100%;
  width: 100%;
}
</style>
@endsection

@section('title', 'Canopy Stories')

@section('content')
    @parent
    <div id="map"></div>
    @include('partials.tutorial-modal')
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
