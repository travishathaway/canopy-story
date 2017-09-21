@extends('layouts.app')

@section('style')
@parent

<link rel="stylesheet" href="{{ mix('css/jquery.fancybox.css') }}" />

@endsection

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-8 mr-auto">
      <h1 class="mt-4">@lang('menu.find_stories')</h1>
    </div>
  </div>
  <form action="" method="get" >
    <div class="row">
      <div class="ml-auto col-sm-12 col-md-8 col-lg-5">
        <input type="text" class="form-control" name="q" placeholder="@lang('post_list.search_placeholder')"
            value="{{ $q }}"/>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-3 mr-auto">
        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Search</button>
          </div>
          <div class="col-6">
            <a href="{{ url('post') }}" role="button" class='btn btn-dark btn-block'>Reset</a>
          </div>
        </div>
      </div>
    </div>
  </form>
  <hr />
  @if($posts->count() > 0)
    @foreach ($posts as $post)
    <div class="row">
      @include('partials.card')
    </div>
    @endforeach
  <div class="row justify-content-center">
      <div class="col-md-7">
        @include('pagination.default', ['paginator' => $posts])
      </div>
  </div>
  @else
  <div class="row">
    <div class="col-md-12 white-bkgrnd">
      <div class="text-center">
        <h3>@lang('post_list.no_results')</h3>
        <p>@lang('post_list.search_other')</p>
        <br />
      </div>
    </div>
  </div>
@endif
@endsection

@section('script')
@parent
<script src="{{ mix('js/jquery.fancybox.js')}}" type="text/javascript"></script>
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

