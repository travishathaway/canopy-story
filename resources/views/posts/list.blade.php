@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="col-md-12 white-bkgrnd search-header">
        <div class="pull-right" id="profile-buttons">
        @if(\App::getLocale() === 'en')
        <a href="?lang=es" class="btn btn-default btn-sm">
          <span class="text-muted"><span class="lang-sm lang-lbl" lang="es"></span></span>
        </a>
        @else
        <a href="?lang=en" class="btn btn-default btn-sm">
          <span class="text-muted"><span class="lang-sm lang-lbl" lang="en"></span></span>
        </a>
        @endif
        @if(Auth::check())
        <a href="/logout" class="btn btn-sm btn-default pull-right">Logout</a>
        @else
        <a href="/login" class="btn btn-sm btn-default pull-right">Login</a>
        @endif
        </div>
        <div class="col-md-12 text-center"><h1><a id="title-link" href="/">{{ config('app.name') }}</a></h1><p/>
        <h4>What&rsquo;s new in your neck of the woods?</h4></div>
        <form action="" method="get">
            <div class="row">
                <div class="col-md-offset-1 col-md-8">
                    <input type="text" class="form-control" name="q" placeholder="Seach for a Tree Story"
                        value="{{ $q }}"/>
                </div>
                <div class="col-md-3">
                    <div class="btn-group pull-right" id="search-buttons">
                        <button type="submit" class="btn btn-default">Search</button>
                        <a href="{{ url('post') }}" class='btn btn-warning'>Clear</a>
                        <a href="{{ url('/') }}" class="btn btn-default" id="list_back_button">Back</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<br />
@if($posts->count() > 0)
<div class="container-fluid">
      @foreach ($posts as $post)
        @include('partials.card')
      @endforeach
  </div>
  <div class="text-center">
    {{ $posts->appends(['q' => $q])->links() }}
  </div>
</div>
@else
<div class="container">
    <div class="text-center">
      <h3>No Results</h3>
      <p>Please try searching for other terms</p>
      <br />
    </div>
</div>
@endif
@endsection

@section('script')
@parent
<script src="{{ asset('js/jquery.fancybox.min.js')}}" type="text/javascript"></script>
<script>
$(document).ready(function(){
  $('.image-container').each(function(idx, obj){
    // Bind events for left and right controls
    $(obj).find('.left-control').on('click', function(){
      var length = $(obj).find('.card-image-container').length;
      var position = $(obj).find('.card-image-container:visible').index();

      var next_pos = position;

      if( next_pos < 1 ){
        next_pos = length;
      }

      $(obj).find('.card-image-container:visible').hide();
      $(obj).find('.card-image-container:nth-child('+next_pos+')').show();
    });

    $(obj).find('.right-control').on('click', function(){
      var length = $(obj).find('.card-image-container').length;
      var position = $(obj).find('.card-image-container:visible').index();

      var next_pos = position + 2;

      if( next_pos > length ){
        next_pos = 1;
      }

      $(obj).find('.card-image-container:visible').hide();
      $(obj).find('.card-image-container:nth-child('+next_pos+')').show();
    });
  });
});
</script>
@endsection

