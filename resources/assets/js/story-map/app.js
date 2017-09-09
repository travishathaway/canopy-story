'use strict';
import L from 'leaflet';
import 'leaflet-hash';
import * as $ from 'jquery';

// Custom module imports
import StyleHelpers from './lib/style_helpers.js';
import './lib/GeoJSON.js';


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
    this.selected_feature_id = undefined;
  }

  /**
   * Zooms to the extent of the feature when event is triggered. This also
   * fires off an event that let's listeners know that a feature has been
   * selected.
   */
  zoomToFeature(e) {
    let feature_id = e.target.feature.properties.ORIG_FID;

    this.selected_feature_id = feature_id;
    this.layers.nbo_polygons.setStyle(StyleHelpers.getDefaultStyle())

    // Zoom map to feature
    this.map.fitBounds(e.target.getBounds());
    e.target.setStyle(StyleHelpers.getSelectedNboStyle());
  }

  /**
   * Highlight the feature on mouseover
   */
  highlight(e){
    e.target.setStyle(StyleHelpers.getHoverStyle());
  }

  /**
   * Return feature to default style on mouseout
   */
  dehighlight(e){
    var style;
    var feature_id = e.target.feature.properties.ORIG_FID;

    if( this.selected_feature_id === feature_id ){
      style = StyleHelpers.getSelectedNboStyle();
    } else {
      style = StyleHelpers.getDefaultStyle();
    }

    e.target.setStyle(style);
  }
}

$(document).ready(function(){
  /**
   * Initialize the map
   */
  let map = L.map(
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
  let geojson_layers = {
    metro_boundary: undefined,
    nbo_polygons: undefined
  }
  
  /**
   * Initialize our hash object
   */
  let hash = new L.Hash(map);
  

  /**
   * Initialize the map control object
   */
  let map_ctrl = new MapCtrl(map, geojson_layers);

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
        onEachFeature: function (feature,layer){
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
});
