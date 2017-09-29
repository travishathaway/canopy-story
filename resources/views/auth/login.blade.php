@extends('layouts.app')

@section('title')
Login
@endsection

@section('content')
<br />
<div class="row justify-content-md-center">
  <div class="col-md-6">
    <div class="text-center">
      <h1>@lang('site.login_to') {{ config('app.name') }}</h1>
      <hr />
      <div class="box">
        <div class="request">
          @include('partials.social-login')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
