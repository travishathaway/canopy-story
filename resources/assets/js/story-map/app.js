import L from 'leaflet';
import 'leaflet-hash';

// Custom module imports
import StyleHelpers from './lib/style_helpers.js';
import './lib/GeoJSON.js';

/**
 * Initialize the map
 */
var map = L.map(
  'map',
  { 
    zoomControl: true,
    maxZoom: 18,
    animate: true,
    duration: 5.0,
    center: [
      45.4933, 
      -122.6862
    ], 
    zoom: 12
  }
);

var hash = new L.Hash(map);

var base = L.tileLayer(
  "http://d.sm.mapstack.stamen.com/((toner,$fff[@60],$fff[hsl-saturation@10]),"+
  "(mapbox-water,$3399cc[hsl-color@40])[@50],parks[multiply],(buildings,$fff[@80],"+
  "$73778c[hsl-color@60])[multiply])/{z}/{x}/{y}.png", 
  {
    attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>,'+
      ' <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> '+
      '&mdash; Map data: &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> '+
      'contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
  }
);

base.addTo(map);


