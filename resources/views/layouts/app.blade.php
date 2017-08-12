<html>
    <head>
        <title>@yield('title')</title>

        @include('partials.base-styles')

        @section('style')
        @show

        <script src="{{ elixir('js/all.js') }}"></script>
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
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        </script>
        @show
    </body>
</html>
