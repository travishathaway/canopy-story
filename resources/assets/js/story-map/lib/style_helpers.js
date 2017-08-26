class StyleHelpers {
  /**
   * Styles the neighborhood boundary polygons
   */
  doStylenbo(feature){
    return {
      color: 'orange',
      fillColor: 'yellow',
      weight: 5,
      dashArray: '9',
      opacity: 1.0,
      fillOpacity: 0.08
    }
  }

  doStyleALL(feature) {
    dataName = feature.properties.NAME.replace("/", " ");
    var story_count = 0;

    $(updated).each(function(){
      if(String(this) == dataName){
        story_count+=1;
      }
    });

    if($.inArray(dataName, updated) > -1){
      color = 'blue';
      fillOpacity = 0.1*story_count;
    } else {
      color = "yellow";
      fillOpacity = 0.00;
    }

    return {
      color: 'orange',
      fillColor: color,
      weight: 1,
      opacity: 1.0,
      fillOpacity: fillOpacity
    };
  }

  doStyleTrees(x, located){
    var contains = false;
    var story_count = 0;

    $(updated_trees).each(function(){
      if($(this)[0] == x.id && $(this)[1] == located){
        contains = true;
      }
      if($(this)[1] == located){
        story_count++;
      }
    });

    var opacity = 0.2 * story_count;
    if(contains){
      return {
        radius: 7.0,
        fillColor: '#1919ff',
        fillOpacity: opacity,
      }
    }
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
