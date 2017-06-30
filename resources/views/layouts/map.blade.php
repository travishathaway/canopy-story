<html>
<head>
  <title>@yield('title')</title>
  @section('styles')
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
	<link rel="stylesheet" href="{{ elixir('css/all.css') }}" />

  @show

    </head>
    <body>
        @yield('content')
        @section('scripts')
        <script src="{{ elixir('js/all.js') }}"></script>
        <script src="{{ asset('js/Autolinker.min.js') }}"></script>
        <script src="{{ asset('js/DistanceGrid.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/MarkerClusterGroup.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/GeoJSONCluster.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/visibility.js') }}"></script>
        <script src="{{ asset('js/leaflet-geojson-selector.js') }}"></script>

        <script src="{{ asset('data/exp_cutnbo.js') }}"></script>
        <script src="{{ asset('data/metro.js') }}"></script>
        @show
    </body>
</html>
