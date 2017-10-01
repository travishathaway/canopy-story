@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-8 mr-auto">
      <h1 class="mt-4">Server Error</h1>
      Please contact us <a href="mailto:{{config('share_email')}}" title="Report error">here</a>
      if this problem persist.
    </div>
  </div>
@endsection
