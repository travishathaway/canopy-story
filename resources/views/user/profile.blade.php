@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="ml-auto col-sm-12 col-lg-6 mr-auto">
      <h1 class="mt-4">@lang('site.profile')</h1>
      <hr />
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
  window.UserProfile.trans = {
    'first_name': '@lang('site.first_name')',
    'last_name': '@lang('site.last_name')',
    'email': '@lang('site.email')',
    'edit': '@lang('site.edit')',
    'save': '@lang('site.save')',
    'cancel': '@lang('site.cancel')'
  }
</script>
<script src="{{mix('js/user-profile.js')}}"></script>
@endsection
