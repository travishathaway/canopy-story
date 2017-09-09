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
    <div class="modal fade" id="formModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Share your story</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>
    @include('partials.tutorial-modal')
@endsection

@section('scripts')
@parent
<script>
/**
* App Globals
 */
window.StoryMap = {};
window.StoryMap.base_dir = '{{ config('app.url') }}';
window.StoryMap.share_email = '{{ config('app.share_email') }}'
window.StoryMap.upload_file_location = '{{ elixir('js/upload.js') }}';
window.StoryMap.updated = [];
window.StoryMap.updated_trees = [];

@if(Auth::check())
window.StoryMap.logged_in = true;
@else
window.StoryMap.logged_in = false;
@endif
</script>

<script src="{{ mix('js/story-map.js') }}"></script>

@endsection
