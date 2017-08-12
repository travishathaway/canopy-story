@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-8 mr-auto">
      <h1 class="mt-4">Profile</h1>
    </div>
  </div>
@endsection

@section('script')
@parent

<script>
$(document).ready(function(){
    $.ajax({
        'method': 'GET',
        'url': '/api/v1/user/1',
        'success': function(data){
            console.log(data);
        },
        'error': function(data){
            console.log(data);
        }
    });
});
</script>

@endsection
