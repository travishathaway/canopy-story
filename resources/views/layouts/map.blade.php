<html>
<head>
    <title>@yield('title')</title>
    @section('styles')
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script src="//cdn.research.pdx.edu/leaflet/0.7.7/leaflet.js"></script>
    <script src="//cdn.research.pdx.edu/jquery/2.2.1/jquery-2.2.1.min.js"></script>
	  <script src="//cdn.research.pdx.edu/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	  <link rel="stylesheet" href="//cdn.research.pdx.edu/bootstrap/3.3.6/css/bootstrap.min.css">
	  <link rel="stylesheet" href="//cdn.research.pdx.edu/leaflet/0.7.7/leaflet.css">

	  <script src="{{ asset('js/leaflet-hash.js') }}"></script>
	  <script src="{{ asset('js/leaflet.markercluster.js') }}"></script>
	  <script src="{{ asset('js/Autolinker.min.js') }}"></script>
	  <script src="{{ asset('js/leaflet.ajax.js') }}" type="text/javascript"></script>
	  <script src="{{ asset('js/leaflet.ajax.min.js') }}" type="text/javascript"></script>
	  <script src="{{ asset('js/DistanceGrid.js') }}" type="text/javascript"></script>
	  <script src="{{ asset('js/MarkerClusterGroup.js') }}" type="text/javascript"></script>
	  <script src="{{ asset('js/GeoJSONCluster.js') }}" type="text/javascript"></script>
	  <script src="{{ asset('js/visibility.js') }}"></script>
    <script src="{{ asset('js/leaflet-geojson-selector.js') }}"></script>

	  <script src="{{ asset('data/exp_cutnbo.js') }}"></script>
	  <script src="{{ asset('data/metro.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/leaflet-geojson-selector.css') }}">
	  <link rel="stylesheet" href="{{ asset('css/MarkerCluster.css') }}">
	  <link rel="stylesheet" href="{{ asset('css/MarkerCluster.Default.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @show
    </head>
    <body>
        @yield('content')
        @section('scripts')
        @show
    </body>
</html>
