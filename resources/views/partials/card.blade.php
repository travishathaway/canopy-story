<div class="card" style="margin-top: 14px;">
  <div class="container container-fluid">
    @if(count(($post->images)) > 0 )
    <div class="row">
      <div class="col-md-12">
        <div class="card-image-container">
          <div class="card-image" 
            style="background-image:url('{{ asset('storage/' . $post->images[0]->image_url)}}');">
          </div>
        </div>
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-md-9">
        <strong>By: </strong>{{ $post->user->first_name}}  {{ $post->user->last_name}}
      </div>
      <div class="col-md-3">
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
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <strong>Location: </strong>
        <a class="location-link" href="{{ url('post') }}?location=EASTMORELAND REED">
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
        <strong>Posted: </strong>{{ $post->created_at }}
      </div>
    </div>
  </div>
</div>
