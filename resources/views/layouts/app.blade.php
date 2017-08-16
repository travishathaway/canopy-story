<html>
  <head>
    <title>@yield('title')</title>

    @include('partials.base-styles')

    @section('style')
    @show
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    @include('partials.site-menu')
    <div class="map-bg">
      <div class="container white-background">
        @section('content')
        @show
      </div>
    </div>
    @section('script')
    <script src="{{ mix('js/app.js') }}"></script>
    @show
  </body>
</html>
