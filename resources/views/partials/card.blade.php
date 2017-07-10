<div class="card" style="margin-top: 14px;">
  <div class="container container-fluid image-container">
    @if(count(($post->images)) > 0 )
    <div class="row">
      <div class="col-md-12 ">
        <div class="card-image">
          @foreach($post->images as $idx => $img)
          @if($idx !== 0)
          <div class="card-image-container" style="display: none">
          @else
          <div class="card-image-container">
          @endif
            <a href="{{asset('storage/' . $img->image_url)}}" data-fancybox="images-{{$post->id}}">
              <img src="{{Image::url(asset('storage/' . $img->image_url),400,375,array('crop')) }}" 
                style="height: auto; width: 100%; text-align: center"/>
            </a>
          </div>
          @endforeach
          @if(count(($post->images)) > 1 )
          <div class="card-image-controls">
            <div class="pull-right">
              <span class="control right-control">
                <span class="glyphicon glyphicon-chevron-right"></span>
              </a>
            </div>
            <span class="control left-control">
              <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
          </div>
          @endif
        </div>
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-md-9">
        <strong>By: </strong>{{ $post->user->first_name}}  {{ $post->user->last_name}}
      </div>
      <div class="col-md-3">
        @if($user) 
        @if($user->id == $post->user_id || $user->isAdmin())
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')" action="{{route('post.delete', $post->id)}}"
          class="pull-right">
          {{ csrf_field() }}
          <input type="hidden" value="8" name="id">
          <button class="style-as-link pull-right" type="submit" title="Flag as Inappropriate?">
            <span class="glyphicon glyphicon-trash"></span>
          </button>
        </form>
        @endif
        @if($user->isAdmin())
        <form method="POST" onsubmit="return confirm('Are you sure you want to flag this post?')" action="{{route('post.update', $post->id)}}"
          class="pull-right" style="margin-right: 3px">
          {{ csrf_field() }}
          <input type="hidden" value="1" name="flagged">
          <button class="style-as-link pull-right" type="submit" title="Flag as Inappropriate?">
            <span class="glyphicon glyphicon-flag"></span>
          </button>
        </form>
        @endif
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <strong>Location: </strong>
        <a class="" href="{{ url('post') }}?q={{ $post->tree_location }}">
          {{ $post->tree_location }}
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="well">
          <p>
            {{ $post->content }}
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <strong>Posted: </strong>{{ $post->created_at->diffForHumans()  }}
      </div>
    </div>
  </div>
</div>
