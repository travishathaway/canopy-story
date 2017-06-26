@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
<div id="wrapper"></div>
<div id="main">
  <div class='text-center' id="center">
    <h1>Sign in to {{ config('app.name') }}</h1>
    <div id="popup-form">
      <div class="box">
        <div class="request">
          @include('partials.social-login')
        </div>
      </div>
    </div>
    <hr>
    <a id="back" href="{{ url('post') }}" class="btn btn-danger">
      I Don't Want To Sign In
    </a>
  </div>
</div>
@endsection
