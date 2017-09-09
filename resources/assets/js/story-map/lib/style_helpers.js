'use strict';
import * as $ from 'jquery';

const StyleHelpers =  {
  /**
   * Styles the neighborhood boundary polygons
   */
  getDefaultStyle: function() {
    var color = "yellow";
    var fillOpacity = 0.0;

    return {
      color: 'orange',
      fillColor: color,
      weight: 1,
      opacity: 1.0,
      fillOpacity: fillOpacity
    };
  },

  /**
   * Get Mouse Over Styles for a polygon
   */
  getHoverStyle: function() {
    return {
      color: 'orange',
      fillColor: 'yellow',
      weight: 5,
      opacity: 1.0,
      fillOpacity: 0.6
    };
  },

  /**
   * Returns the style for a currently selected neighborhood
   */
  getSelectedNboStyle: function(){
    return {
      color: 'orange',
      fillColor: 'yellow',
      weight: 5,
      opacity: 1.0,
      fillOpacity: 0.15
    }
  },

  doStyleTrees: function(x, located){
    // var opacity = 0.2 * story_count;

    if (x.properties.MAX_GRID_C >= 50.0 && x.properties.MAX_GRID_C <= 62.9233396667) {
      return {
        radius: 3.0,
        fillColor: '#94de83',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 62.9233396667 && x.properties.MAX_GRID_C <= 73.609985) {
      return {
        radius: 3.4,
        fillColor: '#85CB75',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 73.609985 && x.properties.MAX_GRID_C <= 83.159973) {
      return {
        radius: 3.8,
        fillColor: '#76B868',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 83.159973 && x.properties.MAX_GRID_C <= 92.26001) {
      return {
        radius: 4.2,
        fillColor: '#67A55B',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 92.26001 && x.properties.MAX_GRID_C <= 101.209991) {
      return {
        radius: 4.6,
        fillColor: '#58934E',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 101.209991 && x.properties.MAX_GRID_C <= 111.110046) {
      return {
        radius: 5.0,
        fillColor: '#4A8041',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 111.110046 && x.properties.MAX_GRID_C <= 123.51001) {
      return {
        radius: 5.3,
        fillColor: '#3B6D34',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 123.51001 && x.properties.MAX_GRID_C <= 141.430003) {
      return {
        radius: 5.6,
        fillColor: '#2C5B27',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 141.430003 && x.properties.MAX_GRID_C <= 220.0) {
      return {
        radius: 5.9,
        fillColor: '#1D481A',
        fillOpacity: 0.8,
      }
    } else if (x.properties.MAX_GRID_C >= 220.0 && x.properties.MAX_GRID_C <= 300.0) {
      return {
        radius: 6.3,
        fillColor: 'red',
        fillOpacity: 0.8,
      }
    }
  }
}

export default StyleHelpers
