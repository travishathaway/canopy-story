@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.fancybox.min.css') }}">
@endsection

@section('content')
<div id="list-container" class="container">
    <div class="row" id="list_header">
        @if(Auth::check())
        <a href="/logout" id="logout" class="btn btn-default pull-right">Logout</a>
        @else
        <a href="/login" id="login" class="btn btn-default pull-right">Login</a>
        @endif
        <?php /*echo $admin_button.$logout; */ ?>
        <div class="col-md-12 text-center"><h1><a id="title-link" href="/">{{ config('app.name') }}</a></h1><p/>
        <h4>What&rsquo;s new in your neck of the woods?</h4></div>
    </div>
    <div class="row" id="search">
        <div class="col-md-12">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-offset-1 col-md-8">
                        <input type="text" class="form-control" name="searchform" placeholder="Seach for a Tree Story">
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
    <div class="row" id="table-info"><div class="col-md-12">
    </div></div>
</div>
<div class="container-fluid">
  <div id="cards-container">
  @foreach ($posts as $post)
    @include('partials.card')
    @endforeach
  </div>

  <div class="text-center">
    {{ $posts->links() }}
  </div>
</div>
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
