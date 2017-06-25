@extends('layouts.app')

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
<div id="cards-container" class="container-fluid">
@foreach ($posts as $post)
  @include('partials.card')
@endforeach

{{ $posts->links() }}
</div>
@endsection

