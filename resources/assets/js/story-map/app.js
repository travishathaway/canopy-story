'use strict';
import L from 'leaflet';
import 'leaflet-hash';
import 'leaflet.markercluster';
import leafletPip from '@mapbox/leaflet-pip';
import 'jquery';
import 'bootstrap';
import Bloodhound from '../typeahead.js/bloodhound.js';


// Custom module imports
import StyleHelpers from './lib/style_helpers.js';
import storyMapFileUploadInit from './lib/upload.js';

/**
 * Module consts that really come from a global object
 */
const DATA_DIRECTORY = '../data/';
const BASE_DIR = window.StoryMap.base_dir;
const LOGGED_IN = window.StoryMap.logged_in;
const UPLOAD_FILE_LOC = window.StoryMap.upload_file_location;
const SHARE_EMAIL = window.StoryMap.share_email;


const LEAFLET_CLUSER_MARKER_OPTIONS = {
  disableClusteringAtZoom: 18,
  spiderfyOnMaxZoom: false,
  polygonOptions: {
    color: 'green'
  }
};


/**
 * This is a class meant to hold all the logic it
 * takes to control a leaflet map.
 */
class MapCtrl {
  /**
   * Intializes the object setting the map and layers properties
   */
  constructor(map, layers){
    this.map = map;
    this.layers = layers;

    /**
     * Currently selected polygon
     */
    this.selected_polygon_id = undefined;

    /**
     * Currently selected polygon name
     */
    this.selected_polygon_props = undefined;

    /**
     * These are the markers contained within a polygon
     */
    this.markers = undefined;

    /**
     * This is the circle marker we use to keep track of our
     * current location
     */
    this.current_location = undefined;

    /**
     * Makes sure we only load the required UPLOAD_FILE_LOC js
     * file just once
     */
    this.upload_js_loaded = false;
  }

  /**
   * Retrieve the point data for a polygon
   */
  getPointsForPolygon(feature) {
    var that = this;
    var filename = DATA_DIRECTORY + feature.properties.asd + '.geojson';

    if( this.markers !== undefined ){
      this.map.removeLayer(this.markers);
    }

    $.getJSON(filename, function(data){
      that.markers = L.markerClusterGroup(LEAFLET_CLUSER_MARKER_OPTIONS);

      that.markers.addLayer(L.geoJson(data, {
        onEachFeature: function(feature, layer){
          layer.on({
            mouseover: function(e){
              e.target.setStyle({
                'radius': 12
              });
            },
            mouseout: function(e){
              var feature = e.target.feature;
              e.target.setStyle(
                StyleHelpers.doStyleTrees(feature, feature.properties.asd)
              )
            },
            click: function(e){
              var popup_html = that.popup_html;

              popup_html = popup_html.replace(
                '--tree_location--', that.selected_polygon_props.asd
              ).replace(
                '--tree_id--', e.target.feature.id
              );

              // Put form HTML in modal
              $('#formModal .modal-body').html(popup_html);
              $('#popup #tree-height').text(
                Math.round(e.target.feature.properties.MAX_GRID_C)
              );
              $('#popup #tree-location').text(that.selected_polygon_props.NAME);
              $('#popup #tree-id').text(e.target.feature.id);

              // Initialized ResumableJs stuff for file uploads if 
              // the user is logged in
              if( LOGGED_IN === true ){
                storyMapFileUploadInit();
              }

              // Show modal
              $('#formModal').modal();
            }
          });
        },
        style: {
          color:'green',
          stroke: '2'
        },
        pointToLayer: function(feature, latlng){
            return new L.CircleMarker(
                latlng, StyleHelpers.doStyleTrees(feature, feature.properties.asd)
            )
        }
      }));

      that.map.addLayer(that.markers);
    });
  }

  /**
   * Zooms to the extent of the feature when event is triggered. This also
   * gets the point data for this polygon and sets it as selected.
   */
  zoomToFeature(e) {
    var prev_feature_id = this.selected_polygon_id;

    this.setSelectedPolygon(e.target.feature);
    e.target.setStyle(StyleHelpers.getSelectedNboStyle());

    this.layers.nbo_polygons.setStyle(StyleHelpers.getDefaultStyle())

    // Zoom map to feature if it isn't already selected 
    if( prev_feature_id !== this.selected_polygon_id ){
      this.map.fitBounds(e.target.getBounds());
    }
  }

  /**
   * Zooms to a specific lat/lng provided
   */
  zoomToLatLng(lat, lng){
    if( this.current_location !== undefined ){
      this.map.removeLayer(this.current_location);
    }

    // Marker our current location on the map with a red dot
    var current_location = L.circle([lat, lng], {
      color: 'red',
      fillColor: '#f03',
      fillOpacity: 0.5,
      radius: 2
    }).addTo(this.map);

    this.current_location = current_location;

    // Set the map to the current lat/lng and zoom to maxim view
    this.map.setView([lat, lng], 18);
  }

  /**
   * Sets feature to currently selected polygon
   */
  setSelectedPolygon(feature){
    var feature_id = feature.properties.ORIG_FID;

    if( feature_id !== this.selected_polygon_id ){
      // Get the point data for this polygon
      this.getPointsForPolygon(feature);
    }

    this.selected_polygon_id = feature_id;
    this.selected_polygon_props = feature.properties;
  }

  /**
   * Highlight the feature on mouseover
   */
  highlight(e){
    var feature_id = e.target.feature.properties.ORIG_FID;

    if( this.selected_polygon_id !== feature_id ){
      e.target.setStyle(StyleHelpers.getHoverStyle());
    }
  }

  /**
   * Return feature to default style on mouseout
   */
  dehighlight(e){
    var style;
    var feature_id = e.target.feature.properties.ORIG_FID;

    if( this.selected_polygon_id === feature_id ){
      style = StyleHelpers.getSelectedNboStyle();
    } else {
      style = StyleHelpers.getDefaultStyle();
    }

    e.target.setStyle(style);
  }
}

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

/**
 * Holds all the layers of the map
 */
var geojson_layers = {
  metro_boundary: undefined,
  nbo_polygons: undefined
}

/**
 * Initialize our hash object
 */
var hash = new L.Hash(map);

/**
 * Initialize the map control object
 */
var map_ctrl = new MapCtrl(map, geojson_layers);

/**
 * Create our base tile layer
 */
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

/** 
 * Add Controls to map
 */
var info = L.control();

/**
 * Add the urban boundary to the map
 */
$.ajax({
  dataType: 'json',
  url: '/data/metro_boundary.json',
  method: 'GET',
  success: function(data){
    var metro_boundary = data;

    geojson_layers.metro_boundary = new L.geoJson(metro_boundary ,{
      style: {
        color: 'purple',
        weight: 5,
        opacity: 0.5,
        fillOpacity: 0
      }
    }).addTo(map);
  }
});

/**
 * Add the neighborhood boundaries to the map
 */
$.ajax({
  dataType: 'json',
  url: '/data/neighborhood_boundaries.json',
  method: 'GET',
  success: function(data){
    var neighborhood_boundaries = data;

    geojson_layers.nbo_polygons = new L.geoJson(neighborhood_boundaries, {
      style: StyleHelpers.getDefaultStyle,
      onEachFeature: function (feature, layer){
        var that = this;

        layer.on({
          mouseover: function(e){
            map_ctrl.highlight(e);
          },
          mouseout: function(e) {
            map_ctrl.dehighlight(e);
          }, 
          click: function(e){
            map_ctrl.zoomToFeature(e);
          }
        });
      }
    }).addTo(map);
  }
});

/**
 * Set up the upload pop content that will allow users to add a
 * tree story. This part of the code is still a bit messy and left
 * over from the first implementation of the story map
 */
if( LOGGED_IN ){
  // User is logged in to social media
  // and has approved this application,
  // so get the treestory form and put
  // it in the popcont variable
  $.ajax({
    url: BASE_DIR + "/popup",
    type: 'get',
    async: true,
    success: function(html){
      map_ctrl.popup_html = html
    }
  });
} else {
  // User is not logged into social media.
  // Fill popcont with login form.
  $.ajax({
    url: BASE_DIR + "/partials/social-login",
    type: 'get',
    async: true,
    success: function(html){
      var popup_html = '<br>';
      popup_html = '<p>To share your story, please sign in using:</p>'
      popup_html += html;
      popup_html += "<p>If you do not want to sign in, you can also send us an email.</p>";
      popup_html += '<a class="btn btn-outline-primary btn-large" style="width: 188px" title="Share via email" href="mailto:'+SHARE_EMAIL+'?'+
          'subject=Canopy Story for tree --tree_id-- at --tree_location--&'+
          'body=Hello, %0D%0A%0D%0AI would like to share my Canopy Story%0D%0A%0D%0A ---Write below this line---%0D%0A%0D%0A">'+
          '<span class="glyphicon glyphicon-envelope"></span> Share via email'+
      '</a>';

      map_ctrl.popup_html = popup_html
    }
  });
}

/**
 * TypeAhead setup. This is the search bar we provided to allow users
 * to quickly zoom to a location when they enter an address. More information
 * and demos can be found here:
 *  - https://twitter.github.io/typeahead.js/examples/
 *  - https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md
 */
var addresses = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/api/v1/address?q=%QUERY',
    wildcard: '%QUERY'
  }
});

$('.typeahead').typeahead({
  hint: false,
  highlight: true,
}, {
  name: 'addresses',
  display: function(obj) {
    return obj.add_full + ', ' + obj.city;
  },
  source: addresses,
}).on('typeahead:selected', function(evt, item){
  map_ctrl.zoomToLatLng(item.lat, item.lng);

  let features = leafletPip.pointInLayer(
    [item.lng, item.lat], map_ctrl.layers.nbo_polygons
  );

  features.forEach(function(feature){
    map_ctrl.setSelectedPolygon(feature.feature);
  });
});
