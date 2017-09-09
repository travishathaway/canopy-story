'use strict';
import L from 'leaflet';
import 'leaflet-hash';
import 'leaflet.markercluster';
//import * as $ from 'jquery';
import 'jquery';
import 'bootstrap';
import Resumable from 'resumablejs';

// Custom module imports
import StyleHelpers from './lib/style_helpers.js';
import './lib/GeoJSON.js';


/**
 * Make Resumable global for use elsewhere
 */
window.Resumable = Resumable;

/**
 * Module consts that really come from a global object
 */
const DATA_DIRECTORY = '../data/';
const BASE_DIR = window.StoryMap.base_dir;
const LOGGED_IN = window.StoryMap.logged_in;
const UPLOAD_FILE_LOC = window.StoryMap.upload_file_location;
const SHARE_EMAIL = window.StoryMap.share_email;


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
      that.markers = L.markerClusterGroup({
        disableClusteringAtZoom: 18
      });

      that.markers.addLayer(L.geoJson(data, {
        onEachFeature: function(feature, layer){
          layer.on({
            click: function(e){
              var popup_html = that.popup_html;

              popup_html = popup_html.replace(
                '--tree_location--', that.selected_polygon_props.asd
              ).replace(
                '--tree_id--', e.target.feature.id
              );

              // Put form HTML in modal
              $('#formModal .modal-body').html(popup_html);

              // Get the script having to do with uploads,
              // but only when an upload needs to be done
              $.getScript(UPLOAD_FILE_LOC);

              // Show modal
              $('#formModal').modal();
            }
          });
        },
        style: {
          color:'green'
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
   * fires off an event that let's listeners know that a feature has been
   * selected.
   */
  zoomToFeature(e) {
    let feature_id = e.target.feature.properties.ORIG_FID;

    if( feature_id !== this.selected_polygon_id ){
      // Get the point data for this polygon
      this.getPointsForPolygon(e.target.feature);
    }

    this.selected_polygon_id = feature_id;
    this.selected_polygon_props = e.target.feature.properties;
    this.layers.nbo_polygons.setStyle(StyleHelpers.getDefaultStyle())

    // Zoom map to feature
    this.map.fitBounds(e.target.getBounds());
    e.target.setStyle(StyleHelpers.getSelectedNboStyle());
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

