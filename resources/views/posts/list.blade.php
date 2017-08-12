@extends('layouts.app')

@section('content')
  <form action="" method="get" class="searchbox">
    <div class="row">
      <div class="col-md-offset-1 col-md-8">
        <input type="text" class="form-control" name="q" placeholder="Seach for a Canopy Story"
            value="{{ $q }}"/>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-6">
            <button type="submit" class="btn btn-primary btn-block">Search</button>
          </div>
          <div class="col-md-6">
            <a href="{{ url('post') }}" role="button" class='btn btn-dark btn-block'>Reset</a>
          </div>
        </div>
      </div>
    </div>
  </form>
  <hr />
  <br />
  @if($posts->count() > 0)
  <div class="visible-lg visible-md">
    <div class="row">
    @foreach ($posts as $post)
      @include('partials.card')
      @if($loop->iteration % 3 == 0)
      </div>
        @if(!$loop->last)
        <div class="row">
        @endif
      @endif
      @if($loop->last)
      </div>
      @endif
    @endforeach
  </div>
  <div class="text-center">
    {{ $posts->appends(['q' => $q])->links() }}
  </div>
  @else
  <div class="row">
    <div class="col-md-12 white-bkgrnd">
      <div class="text-center">
        <h3>No Results</h3>
        <p>Please try searching for other terms</p>
        <br />
      </div>
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

