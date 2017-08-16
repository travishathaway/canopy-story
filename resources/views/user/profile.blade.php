@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-6 mr-auto">
      <h1 class="mt-4">Profile</h1>
      <div id="user-profile"></div>
    </div>
  </div>
@endsection

@section('script')
@parent
<script>
  /**
   * User Profile obejct for app
   */
  window.UserProfile = {};
  window.UserProfile.user_resource_url = '/api/v1/user/{{$user->id}}';
</script>
<script src="{{mix('js/user-profile.js')}}"></script>
@endsection
