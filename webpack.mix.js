let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/**
 * Vendor JS
 */
mix.js([
  'resources/assets/js/app.js'
], 'public/js/app.js')

/**
 * React Apps
 */
.react([
  'resources/assets/js/user-profile/app.js'
], 'public/js/user-profile.js')

.js(
  'resources/assets/bower/fancybox/dist/jquery.fancybox.js', 
  'public/js/jquery.fancybox.js'
)

/**
 * Combine Map JS
 */
.combine([
    'resources/assets/bower/resumable.js/resumable.js',
    'resources/assets/bower/leaflet/dist/leaflet.js',
    'resources/assets/bower/leaflet-ajax/dist/leaflet.ajax.js',
    'resources/assets/bower/leaflet-hash/leaflet-hash.js',
    'resources/assets/js/map/GeoJSON.js',
    'resources/assets/js/map/Autolinker.min.js',
    'resources/assets/js/map/MarkerClusterGroup.js',
    'resources/assets/js/map/GeoJSONCluster.js',
    'resources/assets/js/map/visibility.js',
    'resources/assets/js/map/leaflet-geojson-selector.js',
    'resources/assets/js/map/exp_cutnbo.js',
    'resources/assets/js/map/metro.js',
    'resources/assets/js/map/popup.js', 
    'resources/assets/js/map/main.js',
], 'public/js/map.js')

/**
 * Upload JS for images on map
 */
.js('resources/assets/js/upload.js', 'public/js/upload.js')

/**
 * RevealJS
 */
.combine([
  'resources/assets/js/reveal.js',
  'resources/assets/js/head.min.js'
], 'public/js/reveal.js')

/**
 * Combine CSS
 */
.styles([
    'resources/assets/css/languages.min.css',
    'resources/assets/css/map/leaflet-geojson-selector.css',
    'resources/assets/css/map/MarkerCluster.css',
    'resources/assets/css/map/MarkerCluster.Default.css',
    'resources/assets/bower/bootstrap/dist/css/bootstrap.min.css',
    'resources/assets/bower/leaflet/dist/leaflet.css',
    'resources/assets/bower/fancybox/dist/jquery.fancybox.min.css',
    'resources/assets/css/main.css'
], 'public/css/all.css')

/**
 * Combine RevealJS styles
 */
.styles([
    'resources/assets/css/reveal.css',
    'resources/assets/css/reveal-black.css'
], 'public/css/reveal.css')

/**
 * fancy box css
 */
.styles(
  'resources/assets/bower/fancybox/dist/jquery.fancybox.css', 
  'public/css/jquery.fancybox.css'
)

/*
 * Combine Font Awesome Styles
 */
.styles([
    'resources/assets/css/font-awesome.min.css'
], 'public/css/font-awesome.min.css')

.version();
