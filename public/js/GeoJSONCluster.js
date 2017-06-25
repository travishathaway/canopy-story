/*
 * L.GeoJSON turns any GeoJSON data into a Leaflet layer.
 */

/*var L = require('leaflet');
var markerClusterGroup = require('./MarkerClusterGroup');*/

var GeoJSON = MarkerClusterGroup.extend({

  initialize: function (geojson, options) {
    L.setOptions(this, options);

    if (!this.options.iconCreateFunction) {
      this.options.iconCreateFunction = this._defaultIconCreateFunction;
    }

    this._featureGroup = L.featureGroup();
    this._featureGroup.on(L.FeatureGroup.EVENTS, this._propagateEvent, this);

    this._nonPointGroup = L.featureGroup();
    this._nonPointGroup.on(L.FeatureGroup.EVENTS, this._propagateEvent, this);

    this._inZoomAnimation = 0;
    this._needsClustering = [];
    this._needsRemoving = []; //Markers removed while we aren't on the map need to be kept track of
    //The bounds of the currently shown area (from _getExpandedVisibleBounds) Updated on zoom/move
    this._currentShownBounds = null;

    this._queue = [];


    this._layers = {};

    if (geojson) {
      this.addData(geojson);
    }
  },

  addData: function (geojson) {
    var features = L.Util.isArray(geojson) ? geojson : geojson.features,
        i, len, feature;

    if (features) {
      for (i = 0, len = features.length; i < len; i++) {
        // only add this if geometry or geometries are set and not null
        feature = features[i];
        if (feature.geometries || feature.geometry || feature.features || feature.coordinates) {
          this.addData(feature);
        }
      }
      return this;
    }

    var options = this.options;

    if (options.filter && !options.filter(geojson)) { return this; }

    var layer = GeoJSON.geometryToLayer(geojson, options);
    if (!layer) {
      return this;
    }
    layer.feature = GeoJSON.asFeature(geojson);

    layer.defaultOptions = layer.options;
    this.resetStyle(layer);

    if (options.onEachFeature) {
      options.onEachFeature(geojson, layer);
    }

    return this.addLayer(layer);
  },

  resetStyle: function (layer) {
    // reset any custom styles
    layer.options = layer.defaultOptions;
    this._setLayerStyle(layer, this.options.style);
    return this;
  },

  setStyle: function (style) {
    return this.eachLayer(function (layer) {
      this._setLayerStyle(layer, style);
    }, this);
  },

  _setLayerStyle: function (layer, style) {
    if (typeof style === 'function') {
      style = style(layer.feature);
    }
    if (layer.setStyle) {
      layer.setStyle(style);
    }
  }
});

L.extend(GeoJSON, {
  geometryToLayer: function (geojson, options) {

    var geometry = geojson.type === 'Feature' ? geojson.geometry : geojson,
        coords = geometry ? geometry.coordinates : null,
        layers = [],
        pointToLayer = options && options.pointToLayer,
        coordsToLatLng = options && options.coordsToLatLng || this.coordsToLatLng,
        latlng, latlngs, i, len;

    if (!coords && !geometry) {
      return null;
    }

    switch (geometry.type) {
    case 'Point':
      latlng = coordsToLatLng(coords);
      return pointToLayer ? pointToLayer(geojson, latlng) : new L.Marker(latlng);

    case 'MultiPoint':
      for (i = 0, len = coords.length; i < len; i++) {
        latlng = coordsToLatLng(coords[i]);
        layers.push(pointToLayer ? pointToLayer(geojson, latlng) : new L.Marker(latlng));
      }
      return new L.FeatureGroup(layers);

    case 'LineString':
    case 'MultiLineString':
      latlngs = this.coordsToLatLngs(coords, geometry.type === 'LineString' ? 0 : 1, coordsToLatLng);
      return new L.Polyline(latlngs, options);

    case 'Polygon':
    case 'MultiPolygon':
      latlngs = this.coordsToLatLngs(coords, geometry.type === 'Polygon' ? 1 : 2, coordsToLatLng);
      return new L.Polygon(latlngs, options);

    case 'GeometryCollection':
      for (i = 0, len = geometry.geometries.length; i < len; i++) {
        var layer = this.geometryToLayer({
          geometry: geometry.geometries[i],
          type: 'Feature',
          properties: geojson.properties
        }, options);

        if (layer) {
          layers.push(layer);
        }
      }
      return new L.FeatureGroup(layers);

    default:
      throw new Error('Invalid GeoJSON object.');
    }
  },

  coordsToLatLng: function (coords) {
    return new L.LatLng(coords[1], coords[0], coords[2]);
  },

  coordsToLatLngs: function (coords, levelsDeep, coordsToLatLng) {
    var latlngs = [];

    for (var i = 0, len = coords.length, latlng; i < len; i++) {
      latlng = levelsDeep ?
              this.coordsToLatLngs(coords[i], levelsDeep - 1, coordsToLatLng) :
              (coordsToLatLng || this.coordsToLatLng)(coords[i]);

      latlngs.push(latlng);
    }

    return latlngs;
  },

  latLngToCoords: function (latlng) {
    return latlng.alt !== undefined ?
        [latlng.lng, latlng.lat, latlng.alt] :
        [latlng.lng, latlng.lat];
  },

  latLngsToCoords: function (latlngs, levelsDeep, closed) {
    var coords = [];

    for (var i = 0, len = latlngs.length; i < len; i++) {
      coords.push(levelsDeep ?
        GeoJSON.latLngsToCoords(latlngs[i], levelsDeep - 1, closed) :
        GeoJSON.latLngToCoords(latlngs[i]));
    }

    if (!levelsDeep && closed) {
      coords.push(coords[0]);
    }

    return coords;
  },

  getFeature: function (layer, newGeometry) {
    return layer.feature ?
        L.extend({}, layer.feature, {geometry: newGeometry}) :
        GeoJSON.asFeature(newGeometry);
  },

  asFeature: function (geoJSON) {
    if (geoJSON.type === 'Feature') {
      return geoJSON;
    }

    return {
      type: 'Feature',
      properties: {},
      geometry: geoJSON
    };
  }
});

var PointToGeoJSON = {
  toGeoJSON: function () {
    return GeoJSON.getFeature(this, {
      type: 'Point',
      coordinates: GeoJSON.latLngToCoords(this.getLatLng())
    });
  }
};

L.Marker.include(PointToGeoJSON);
L.Circle.include(PointToGeoJSON);
L.CircleMarker.include(PointToGeoJSON);

L.Polyline.prototype.toGeoJSON = function () {
  var multi = !L.Polyline._flat(this._latlngs);

  var coords = GeoJSON.latLngsToCoords(this._latlngs, multi ? 1 : 0);

  return GeoJSON.getFeature(this, {
    type: (multi ? 'Multi' : '') + 'LineString',
    coordinates: coords
  });
};

L.Polygon.prototype.toGeoJSON = function () {
  var holes = !L.Polyline._flat(this._latlngs),
      multi = holes && !L.Polyline._flat(this._latlngs[0]);

  var coords = GeoJSON.latLngsToCoords(this._latlngs, multi ? 2 : holes ? 1 : 0, true);

  if (!holes) {
    coords = [coords];
  }

  return GeoJSON.getFeature(this, {
    type: (multi ? 'Multi' : '') + 'Polygon',
    coordinates: coords
  });
};


L.LayerGroup.include({
  toMultiPoint: function () {
    var coords = [];

    this.eachLayer(function (layer) {
      coords.push(layer.toGeoJSON().geometry.coordinates);
    });

    return GeoJSON.getFeature(this, {
      type: 'MultiPoint',
      coordinates: coords
    });
  },

  toGeoJSON: function () {

    var type = this.feature && this.feature.geometry && this.feature.geometry.type;

    if (type === 'MultiPoint') {
      return this.toMultiPoint();
    }

    var isGeometryCollection = type === 'GeometryCollection',
      jsons = [];

    this.eachLayer(function (layer) {
      if (layer.toGeoJSON) {
        var json = layer.toGeoJSON();
        jsons.push(isGeometryCollection ? json.geometry : GeoJSON.asFeature(json));
      }
    });

    if (isGeometryCollection) {
      return GeoJSON.getFeature(this, {
        geometries: jsons,
        type: 'GeometryCollection'
      });
    }

    return {
      type: 'FeatureCollection',
      features: jsons
    };
  }
});

/*module.exports = function (geojson, options) {
  return new GeoJSON(geojson, options);
};*/