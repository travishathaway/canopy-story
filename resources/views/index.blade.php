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
    <div class="map-legend d-none d-md-block">
        <button class="btn btn-info" data-toggle="modal" data-target="#tutorial-modal">
          How to use this map <i class="fa fa-question-circle"></i>
        </button>
    </div>
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

var updated = [];
var updated_trees = [];
</script>

<script src="{{ mix('js/map.js') }}"></script>

@endsection
