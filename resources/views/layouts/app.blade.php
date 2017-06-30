<html>
    <head>
        <title>@yield('title')</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <meta charset="utf-8" />

        <link rel="stylesheet" href="{{ elixir('css/all.css') }}" />
        @section('style')
        @show

        <script src="{{ elixir('js/all.js') }}"></script>
    </head>
    <body>
        <div id="list-background"></div>
        @yield('content')

        @section('script')
        @show
    </body>
</html>
