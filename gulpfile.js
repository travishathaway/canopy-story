const elixir = require('laravel-elixir');
const gulp = require('gulp');

require('laravel-elixir-remove');

elixir.config.sourcemaps = false;

elixir(mix => {
    // Remove current build
    mix.remove('public/build');

    // Combine CSS
    mix.styles([
        'main.css',
        'languages.min.css',
        'map/leaflet-geojson-selector.css',
        'map/MarkerCluster.css',
        'map/MarkerCluster.Default.css',
        '../bower/bootstrap/dist/css/bootstrap.min.css',
        '../bower/leaflet/dist/leaflet.css',
        '../bower/fancybox/dist/jquery.fancybox.min.css',
    ])

    // Combine JS
    mix.scripts([
        '../bower/jquery/dist/jquery.js',
        '../bower/bootstrap/dist/js/bootstrap.min.js',
        '../bower/leaflet/dist/leaflet.js',
        '../bower/leaflet-ajax/dist/leaflet.ajax.js',
        '../bower/leaflet-hash/leaflet-hash.js',
    ]);

    mix.scripts([
        'popup.js', 
        'main.js',
        '../bower/resumable.js/resumable.js'
    ], 'public/js/map.js');

    mix.scripts([
        'upload.js'
    ], 'public/js/upload.js');

    // Version compiled assets
    mix.version(['css/all.css', 'js/all.js', 'js/map.js', 'js/upload.js']);

    // Copy over images and fonts
    mix.copy('resources/assets/bower/leaflet/dist/images', 'public/build/images');
    mix.copy('resources/assets/bower/bootstrap/dist/fonts', 'public/build/fonts');
    mix.copy('resources/assets/images/', 'public/build/images');
});
