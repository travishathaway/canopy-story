<html>
  <head>
    <title>@yield('title')</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
