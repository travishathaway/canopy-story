<html>
    <head>
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <meta charset="utf-8" />

        <link rel="stylesheet" href="//cdn.research.pdx.edu/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/main.css') }}">

        <script src="//cdn.research.pdx.edu/jquery/2.2.1/jquery-2.2.1.min.js"></script>	
        <script src="//cdn.research.pdx.edu/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="list-background"></div>
        @yield('content')
    </body>
</html>
