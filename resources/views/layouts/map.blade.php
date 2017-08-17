<html>
<head>
  <title>@yield('title')</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @include('partials.base-styles')

  @section('styles')
  @show
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
  <body>
      @section('content')
          @include('partials.site-menu')
      @show

      @section('scripts')
      <script src="{{ mix('js/app.js') }}"></script>
      @show
  </body>
</html>
