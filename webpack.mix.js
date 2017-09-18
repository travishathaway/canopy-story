'use strict';
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
 * Javascript for the story map js
 */
.js(
  'resources/assets/js/story-map/app.js',
  'public/js/story-map.js'
)

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
    'resources/assets/css/typeaheadjs.css',
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
