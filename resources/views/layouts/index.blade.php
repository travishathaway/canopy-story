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

    @if(App::environment() == 'prod')
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  
        ga('create', '{{ config('app.ga_id') }}', 'auto');
        ga('send', 'pageview');
  
      </script>
    @endif
  </head>
  <body>
    @include('partials.site-menu')
    <div class="header-offset">
    @section('content')
    @show
    </div>
    @section('script')
    <script src="{{ mix('js/app.js') }}"></script>
    @show
  </body>
</html>

