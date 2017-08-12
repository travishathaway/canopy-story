
function createCarousel(img_urls, located, base_dir){
    var count = 0;
    if(img_urls != null){
        count = img_urls.length;
    }
    var html = "<div id='popup-image-container'>";
    // Case 1: 1 story, or stories with no image.
    if(count == 1){
        html += '<a href="'+base_dir+'list.php?location='+located+'&id='+img_urls[0][0]+'">';
        html += '<div id="story-link" style="background-image: url(\'';
        if(img_urls[0][1] != ''){
            html += base_dir+img_urls[0][1];
        } else {
            html += base_dir+'pictures/tree.png';
        }
        html +='\');"';
        html += ">";
        html += "<div class='carousel-caption'>";
        html += "<p>"+img_urls[0][2]+"</p>";
        html += "</div>";
        html += "</div></a>";
    } else {
        html += "<div id='carousel' class='carousel slide' data-ride='carousel'>";
        html += "<ol class='carousel-indicators'>";
        for(i=0; i<count; i++){
            html += "<li data-target='#carousel' data-slide-to=\""+i+"\" ";
            if(i==0){
                html += "class='active' ";
            }
            html += "></li>";
        }
        html += "</ol>";
        html += "<div class='carousel-inner' role='listbox'>";
        for(i=0; i<count; i++){
            html += '<div class="item';
            if(i==0){
                html += ' active';
            }
            html += '" role="listbox">';
            html += '<a href="'+base_dir+'list.php?location='+located+'&id='+img_urls[i][0]+'">';
            html += '<div id="story-link" style="background-image: url(\'';
            if(img_urls[i][1] != ''){
                html += base_dir+img_urls[i][1];
            } else {
                html += base_dir+'pictures/tree.png';
            }
            html +='\');"';
            html += ">";
            html += "<div class='carousel-caption'>";
            html += "<p>"+img_urls[i][2]+"</p>";
            html += "</div>";
            html += "</div></a></div>";
        }
        html += "</div>";
        html += '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">';
        html += '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
        html += '<span class="sr-only">Previous</span>';
        html += '</a>';
        html += '<a class="right carousel-control" href="#carousel" role="button" data-slide="next">';
        html += '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
        html += '<span class="sr-only">Next</span>';
        html += '</a>';
        html += "</div>";
    }
    html += "</div>";
    return html;
}

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
var base = L.tileLayer("http://d.sm.mapstack.stamen.com/((toner,$fff[@60],$fff[hsl-saturation@10]),(mapbox-water,$3399cc[hsl-color@40])[@50],parks[multiply],(buildings,$fff[@80],$73778c[hsl-color@60])[multiply])/{z}/{x}/{y}.png", {
attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data: &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'});
base.addTo(map);

clusterOn = false;
clusterZoom = 17;
loadnumber = 1;
var noHighlight = [];

// Add colors for map elements
function doStylenbo(feature) {
    return {
        color: 'orange',
        fillColor: 'yellow',
        weight: 5,
        dashArray: '9',
        opacity: 1.0,
        fillOpacity: 0.08
    };
}

function doStyleALL(feature) {
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

function doStyleTrees(x, located){
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
        };
    };

function highlight(e) {
    if (noHighlight[0] == e.target.feature.properties.asd){
        info.update(e.target.feature.properties);
    } else {
    var asdf = e.target
        asdf.setStyle({
            color: 'orange',
            fillColor: 'yellow',
            weight: 5,
            opacity: 1.0,
            fillOpacity: 0.6
        });
    info.update(asdf.feature.properties);
    }
}

function dehighlight(e) {
    dataName = e.target.feature.properties.NAME.replace("/", " ");
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
    if (noHighlight[0] == e.target.feature.properties.asd){
    } else {
    var asdf = e.target
        asdf.setStyle({
            color: 'orange',
            fillColor: color,
            weight: 1,
            opacity: 1.0,
            fillOpacity: fillOpacity
        });
    info.update();
    }
}

function zoomToFeature(e) {
    /////////////////////////////
    //AJAX LOADING GIF
    /////////////////////////////
    var loadingGIF = function(){
        $.ajaxSetup({async: true})
        var gifURL = "pictures/ajax-loader.gif"
        var gif = '<div class="cont" style="z-index:9999999999999999;position:absolute;margin:auto;top:0;right:0;bottom:0;left:0;width:30%;height: 75px;background-color:rgba(255,255,255,0.85);border-radius:25px;"><h1 style="text-align:center;color:darkgreen;"><b>LOADING...</b></h1></div>';//<img style="z-index:9999999999999999;position:absolute;margin:auto;top:0;right:0;bottom:0;left:0;" src="pictures/ajax-loader.gif">
        $('body').append(gif);
        $( ".cont" ).ready(function(){
        $.ajax({async: true})

        // This is where the logic for UI updates relating to
        // new posts will be put

        });
    };

    if (noHighlight[0] == e.target.feature.properties.asd){
    } else {
        setTimeout(loadingGIF(),1)
        if(map.getZoom() >17){
        } else{
            map.fitBounds(e.target.getBounds());
        }
        nbo_polygons.setStyle({
        fillOpacity: 0.0,
        weight: 1
    });
    var y = e.target.feature.properties.asd;
    e.target.setStyle({
        color: 'orange',
        fillColor: 'yellow',
        weight: 5,
        opacity: 1.0,
        fillOpacity: 0.15
    });

    nboChange(y);
    }
}

// Info div logic
var info = L.control();
info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};

// Update hover text
info.update = function (e) {
    this._div.innerHTML = (e ?
    '<b>' + e.NAME + '</b>'
    : 'Hover Over Neighborhood');
};

info.addTo(map);
var aoi_line = new L.geoJson(exp_metro,{
    style: {
        color: 'purple',
        weight: 5,
        opacity: 0.5,
        fillOpacity: 0
    }
}).addTo(map);

var nbo_polygons = new L.geoJson(exp_cutnbo,{
    style: doStyleALL,
    onEachFeature: function (feature,layer){
        var asd_var = feature.properties.asd
        popcont = '</td></tr><tr><th scope="row">treesborhood: </th><td>' + Autolinker.link(String(feature.properties['asd'])) + '</td></tr></table>';
        layer.on({
                mouseover: highlight,
                mouseout: dehighlight,
                click: zoomToFeature
        });
    }
});
nbo_polygons.addTo(map);
if (clusterOn){
    var markers = L.markerClusterGroup({
    //disableClusteringAtZoom: clusterZoom,
    showCoverageOnHover: false,
    removeOutsideVisibleBounds: true
    });
} else {
    var visibleLayers = L.layerGroup();
    visibleLayers.addTo(map);
};

// Get the popup content
var popcont = "";
function getPopupContent(){
    try {
        if(logged_in){
            // User is logged in to social media
            // and has approved this application,
            // so get the treestory form and put
            // it in the popcont variable
            $.ajax({
                url: base_dir+"/popup",
                type: 'get',
                async: true,
                success: function(html){
                    popcont = html;
                }
            });
        }
        else {
            // User is not logged into social media.
            // Fill popcont with login form.
            $.ajax({
                url: base_dir+"/partials/social-login",
                type: 'get',
                async: true,
                success: function(html){
                    popcont = '<br>';
                    popcont = '<p>To share your story, please sign in using:</p>'
                    popcont += html;
                    popcont += "<p>If you do not want to sign in, you can also send us an email.</p>";
                    popcont += '<a class="btn btn-default btn-large" style="width: 188px" title="Share via email" href="mailto:'+share_email+'?'+
                        'subject=Canopy Story for tree --tree_id-- at --tree_location--&'+
                        'body=Hello, %0D%0A%0D%0AI would like to share my Canopy Story%0D%0A%0D%0A ---Write below this line---%0D%0A%0D%0A">'+
                        '<span class="glyphicon glyphicon-envelope"></span> Share via email'+
                    '</a>';
                }
            });
        }
    }
    catch(ReferenceError){
        // Things most likely havent loaded yet.
        setTimeout(function(){ getPopupContent()}, 250);
    }
}
getPopupContent();

function nboChange(x){
    noHighlight.splice(0)
    if (clusterOn){
        if (loadnumber !== 1){
            markers.clearLayers();
        };
    } else {
        if (typeof visibleLayers  !== 'undefined'){
            visibleLayers.clearLayers();
        };
    };
    loadnumber=2
    var sel = x;
    noHighlight.push(sel);
    dataName = sel.replace(/ /g, "_");
    dataName2 = sel.replace(/_/g, " ");
    dataPath = String("data/" + dataName + ".geojson");
    var trees = new L.GeoJSON.AJAX((dataPath), {
            style: function(feature){
            return{color:'green'}
        },
            pointToLayer: function(feature, latlng){
            return new L.CircleMarker(latlng, doStyleTrees(feature, dataName2))//{radius:6,color:'green',fillOpacity:0.7})
        },
            onEachFeature: function (feature,layer){
            var h = Math.round(feature.properties.MAX_GRID_C)
            var idNumber = String(feature.id);
            var colLen = dataName2.length + 9;
            if (colLen > 30){
                colLen = 30;
            }
            if (colLen < 21) {
                colLen = 21;
            }

            // Get tree info
            var height = Autolinker.link(String(h) + 'ft');
            var located = Autolinker.link(dataName2);
            var id = Autolinker.link(idNumber);
            // Create template for info
            template = '<div id="popup" ';
            if(logged_in==false){
                template += 'style="max-width: 201px;">';
            } else {
                template += 'style="max-width: 258px;">';
            }

      var tree_info = '<div class="row"><div class="col-md-4"><strong>Height</strong></div><div class="col-md-8">' + height + '</div></div><div class="row"><div class="col-md-4"><strong>Location</strong></div><div class="col-md-8">' + located + '</div></div><div class="row"><div class="col-md-4"><strong>Tree ID</strong></div><div id="tree-id" class="col-md-8">' + id + '</div></div>';

        var contains = false;
        var story_count = 0;
        var image_url = [];

        $(updated_trees).each(function(){
            if($(this)[0] == id && $(this)[1] == located){
                contains = true;
                story_count++;
                image_url.push([id, $(this)[2], $(this)[3]]);
            }
        });

        if(contains){
            var scrolldiv = createCarousel(image_url, located, base_dir);
            template += scrolldiv;
        } else {
            template += "<div id='popup-link' class='text-center'><a href='"+base_dir+"/post?q="+located+"' class='text-center'>Find stories in this area.</a></div>";
        }

        template += tree_info;

        // Replace our template values with the actual values from
        // the tree data set.
        popcont_with_vals = popcont.replace(
            '--tree_location--', located
        ).replace(
            '--tree_id--', id
        );

        // Update popup content
        template += popcont_with_vals;
        layer.bindPopup(template);

        jCount= [];
        jCount.push(idNumber);

        }
    });

    if (clusterOn){
            trees.on('data:loaded', function (){
            markers.addLayer(trees);
        });
        map.addLayer(markers);
    } else {
        visibleLayers.addLayer(trees);
    };

    trees.on('data:loaded', function (){
        $( ".cont" ).remove();
    });

    // Get the script having to do with uploads,
    // but only when an upload needs to be done
    $.getScript(upload_file_location);
};

$('#menu').css('margin-top', $('.leaflet-control-zoom-out').height()*2 + 20);
$('#menu').css('margin-left', 10);

/*
* MIT Licensed
* http://www.23developer.com/opensource
* http://github.com/23/resumable.js
* Steffen Tiedemann Christensen, steffen@23company.com
*/

(function(){
"use strict";

  var Resumable = function(opts){
    if ( !(this instanceof Resumable) ) {
      return new Resumable(opts);
    }
    this.version = 1.0;
    // SUPPORTED BY BROWSER?
    // Check if these features are support by the browser:
    // - File object type
    // - Blob object type
    // - FileList object type
    // - slicing files
    this.support = (
                   (typeof(File)!=='undefined')
                   &&
                   (typeof(Blob)!=='undefined')
                   &&
                   (typeof(FileList)!=='undefined')
                   &&
                   (!!Blob.prototype.webkitSlice||!!Blob.prototype.mozSlice||!!Blob.prototype.slice||false)
                   );
    if(!this.support) return(false);


    // PROPERTIES
    var $ = this;
    $.files = [];
    $.defaults = {
      chunkSize:1*1024*1024,
      forceChunkSize:false,
      simultaneousUploads:3,
      fileParameterName:'file',
      chunkNumberParameterName: 'resumableChunkNumber',
      chunkSizeParameterName: 'resumableChunkSize',
      currentChunkSizeParameterName: 'resumableCurrentChunkSize',
      totalSizeParameterName: 'resumableTotalSize',
      typeParameterName: 'resumableType',
      identifierParameterName: 'resumableIdentifier',
      fileNameParameterName: 'resumableFilename',
      relativePathParameterName: 'resumableRelativePath',
      totalChunksParameterName: 'resumableTotalChunks',
      throttleProgressCallbacks: 0.5,
      query:{},
      headers:{},
      preprocess:null,
      method:'multipart',
      uploadMethod: 'POST',
      testMethod: 'GET',
      prioritizeFirstAndLastChunk:false,
      target:'/',
      testTarget: null,
      parameterNamespace:'',
      testChunks:true,
      generateUniqueIdentifier:null,
      getTarget:null,
      maxChunkRetries:100,
      chunkRetryInterval:undefined,
      permanentErrors:[400, 404, 415, 500, 501],
      maxFiles:undefined,
      withCredentials:false,
      xhrTimeout:0,
      clearInput:true,
      maxFilesErrorCallback:function (files, errorCount) {
        var maxFiles = $.getOpt('maxFiles');
        alert('Please upload no more than ' + maxFiles + ' file' + (maxFiles === 1 ? '' : 's') + ' at a time.');
      },
      minFileSize:1,
      minFileSizeErrorCallback:function(file, errorCount) {
        alert(file.fileName||file.name +' is too small, please upload files larger than ' + $h.formatSize($.getOpt('minFileSize')) + '.');
      },
      maxFileSize:undefined,
      maxFileSizeErrorCallback:function(file, errorCount) {
        alert(file.fileName||file.name +' is too large, please upload files less than ' + $h.formatSize($.getOpt('maxFileSize')) + '.');
      },
      fileType: [],
      fileTypeErrorCallback: function(file, errorCount) {
        alert(file.fileName||file.name +' has type not allowed, please upload files of type ' + $.getOpt('fileType') + '.');
      }
    };
    $.opts = opts||{};
    $.getOpt = function(o) {
      var $opt = this;
      // Get multiple option if passed an array
      if(o instanceof Array) {
        var options = {};
        $h.each(o, function(option){
          options[option] = $opt.getOpt(option);
        });
        return options;
      }
      // Otherwise, just return a simple option
      if ($opt instanceof ResumableChunk) {
        if (typeof $opt.opts[o] !== 'undefined') { return $opt.opts[o]; }
        else { $opt = $opt.fileObj; }
      }
      if ($opt instanceof ResumableFile) {
        if (typeof $opt.opts[o] !== 'undefined') { return $opt.opts[o]; }
        else { $opt = $opt.resumableObj; }
      }
      if ($opt instanceof Resumable) {
        if (typeof $opt.opts[o] !== 'undefined') { return $opt.opts[o]; }
        else { return $opt.defaults[o]; }
      }
    };

    // EVENTS
    // catchAll(event, ...)
    // fileSuccess(file), fileProgress(file), fileAdded(file, event), filesAdded(files, filesSkipped), fileRetry(file),
    // fileError(file, message), complete(), progress(), error(message, file), pause()
    $.events = [];
    $.on = function(event,callback){
      $.events.push(event.toLowerCase(), callback);
    };
    $.fire = function(){
      // `arguments` is an object, not array, in FF, so:
      var args = [];
      for (var i=0; i<arguments.length; i++) args.push(arguments[i]);
      // Find event listeners, and support pseudo-event `catchAll`
      var event = args[0].toLowerCase();
      for (var i=0; i<=$.events.length; i+=2) {
        if($.events[i]==event) $.events[i+1].apply($,args.slice(1));
        if($.events[i]=='catchall') $.events[i+1].apply(null,args);
      }
      if(event=='fileerror') $.fire('error', args[2], args[1]);
      if(event=='fileprogress') $.fire('progress');
    };


    // INTERNAL HELPER METHODS (handy, but ultimately not part of uploading)
    var $h = {
      stopEvent: function(e){
        e.stopPropagation();
        e.preventDefault();
      },
      each: function(o,callback){
        if(typeof(o.length)!=='undefined') {
          for (var i=0; i<o.length; i++) {
            // Array or FileList
            if(callback(o[i])===false) return;
          }
        } else {
          for (i in o) {
            // Object
            if(callback(i,o[i])===false) return;
          }
        }
      },
      generateUniqueIdentifier:function(file, event){
        var custom = $.getOpt('generateUniqueIdentifier');
        if(typeof custom === 'function') {
          return custom(file, event);
        }
        var relativePath = file.webkitRelativePath||file.fileName||file.name; // Some confusion in different versions of Firefox
        var size = file.size;
        return(size + '-' + relativePath.replace(/[^0-9a-zA-Z_-]/img, ''));
      },
      contains:function(array,test) {
        var result = false;

        $h.each(array, function(value) {
          if (value == test) {
            result = true;
            return false;
          }
          return true;
        });

        return result;
      },
      formatSize:function(size){
        if(size<1024) {
          return size + ' bytes';
        } else if(size<1024*1024) {
          return (size/1024.0).toFixed(0) + ' KB';
        } else if(size<1024*1024*1024) {
          return (size/1024.0/1024.0).toFixed(1) + ' MB';
        } else {
          return (size/1024.0/1024.0/1024.0).toFixed(1) + ' GB';
        }
      },
      getTarget:function(request, params){
        var target = $.getOpt('target');

        if (request === 'test' && $.getOpt('testTarget')) {
          target = $.getOpt('testTarget') === '/' ? $.getOpt('target') : $.getOpt('testTarget');
        }

        if (typeof target === 'function') {
          return target(params);
        }

        var separator = target.indexOf('?') < 0 ? '?' : '&';
        var joinedParams = params.join('&');

        return target + separator + joinedParams;
      }
    };

    var onDrop = function(event){
      $h.stopEvent(event);

      //handle dropped things as items if we can (this lets us deal with folders nicer in some cases)
      if (event.dataTransfer && event.dataTransfer.items) {
        loadFiles(event.dataTransfer.items, event);
      }
      //else handle them as files
      else if (event.dataTransfer && event.dataTransfer.files) {
        loadFiles(event.dataTransfer.files, event);
      }
    };
    var preventDefault = function(e) {
      e.preventDefault();
    };

    /**
     * processes a single upload item (file or directory)
     * @param {Object} item item to upload, may be file or directory entry
     * @param {string} path current file path
     * @param {File[]} items list of files to append new items to
     * @param {Function} cb callback invoked when item is processed
     */
    function processItem(item, path, items, cb) {
      var entry;
      if(item.isFile){
        // file provided
        return item.file(function(file){
          file.relativePath = path + file.name;
          items.push(file);
          cb();
        });
      }else if(item.isDirectory){
        // item is already a directory entry, just assign
        entry = item;
      }else if(item instanceof File) {
        items.push(item);
      }
      if('function' === typeof item.webkitGetAsEntry){
        // get entry from file object
        entry = item.webkitGetAsEntry();
      }
      if(entry && entry.isDirectory){
        // directory provided, process it
        return processDirectory(entry, path + entry.name + '/', items, cb);
      }
      if('function' === typeof item.getAsFile){
        // item represents a File object, convert it
        item = item.getAsFile();
        item.relativePath = path + item.name;
        items.push(item);
      }
      cb(); // indicate processing is done
    }


    /**
     * cps-style list iteration.
     * invokes all functions in list and waits for their callback to be
     * triggered.
     * @param  {Function[]}   items list of functions expecting callback parameter
     * @param  {Function} cb    callback to trigger after the last callback has been invoked
     */
    function processCallbacks(items, cb){
      if(!items || items.length === 0){
        // empty or no list, invoke callback
        return cb();
      }
      // invoke current function, pass the next part as continuation
      items[0](function(){
        processCallbacks(items.slice(1), cb);
      });
    }

    /**
     * recursively traverse directory and collect files to upload
     * @param  {Object}   directory directory to process
     * @param  {string}   path      current path
     * @param  {File[]}   items     target list of items
     * @param  {Function} cb        callback invoked after traversing directory
     */
    function processDirectory (directory, path, items, cb) {
      var dirReader = directory.createReader();
      dirReader.readEntries(function(entries){
        if(!entries.length){
          // empty directory, skip
          return cb();
        }
        // process all conversion callbacks, finally invoke own one
        processCallbacks(
          entries.map(function(entry){
            // bind all properties except for callback
            return processItem.bind(null, entry, path, items);
          }),
          cb
        );
      });
    }

    /**
     * process items to extract files to be uploaded
     * @param  {File[]} items items to process
     * @param  {Event} event event that led to upload
     */
    function loadFiles(items, event) {
      if(!items.length){
        return; // nothing to do
      }
      $.fire('beforeAdd');
      var files = [];
      processCallbacks(
          Array.prototype.map.call(items, function(item){
            // bind all properties except for callback
            return processItem.bind(null, item, "", files);
          }),
          function(){
            if(files.length){
              // at least one file found
              appendFilesFromFileList(files, event);
            }
          }
      );
    };

    var appendFilesFromFileList = function(fileList, event){
      // check for uploading too many files
      var errorCount = 0;
      var o = $.getOpt(['maxFiles', 'minFileSize', 'maxFileSize', 'maxFilesErrorCallback', 'minFileSizeErrorCallback', 'maxFileSizeErrorCallback', 'fileType', 'fileTypeErrorCallback']);
      if (typeof(o.maxFiles)!=='undefined' && o.maxFiles<(fileList.length+$.files.length)) {
        // if single-file upload, file is already added, and trying to add 1 new file, simply replace the already-added file
        if (o.maxFiles===1 && $.files.length===1 && fileList.length===1) {
          $.removeFile($.files[0]);
        } else {
          o.maxFilesErrorCallback(fileList, errorCount++);
          return false;
        }
      }
      var files = [], filesSkipped = [], remaining = fileList.length;
      var decreaseReamining = function(){
        if(!--remaining){
          // all files processed, trigger event
          if(!files.length && !filesSkipped.length){
            // no succeeded files, just skip
            return;
          }
          window.setTimeout(function(){
            $.fire('filesAdded', files, filesSkipped);
          },0);
        }
      };
      $h.each(fileList, function(file){
        var fileName = file.name;
        if(o.fileType.length > 0){
          var fileTypeFound = false;
          for(var index in o.fileType){
            var extension = '.' + o.fileType[index];
            if(fileName.indexOf(extension, fileName.length - extension.length) !== -1){
              fileTypeFound = true;
              break;
            }
          }
          if (!fileTypeFound) {
            o.fileTypeErrorCallback(file, errorCount++);
            return false;
          }
        }

        if (typeof(o.minFileSize)!=='undefined' && file.size<o.minFileSize) {
          o.minFileSizeErrorCallback(file, errorCount++);
          return false;
        }
        if (typeof(o.maxFileSize)!=='undefined' && file.size>o.maxFileSize) {
          o.maxFileSizeErrorCallback(file, errorCount++);
          return false;
        }

        function addFile(uniqueIdentifier){
          if (!$.getFromUniqueIdentifier(uniqueIdentifier)) {(function(){
            file.uniqueIdentifier = uniqueIdentifier;
            var f = new ResumableFile($, file, uniqueIdentifier);
            $.files.push(f);
            files.push(f);
            f.container = (typeof event != 'undefined' ? event.srcElement : null);
            window.setTimeout(function(){
              $.fire('fileAdded', f, event)
            },0);
          })()} else {
            filesSkipped.push(file);
          };
          decreaseReamining();
        }
        // directories have size == 0
        var uniqueIdentifier = $h.generateUniqueIdentifier(file, event);
        if(uniqueIdentifier && typeof uniqueIdentifier.then === 'function'){
          // Promise or Promise-like object provided as unique identifier
          uniqueIdentifier
          .then(
            function(uniqueIdentifier){
              // unique identifier generation succeeded
              addFile(uniqueIdentifier);
            },
           function(){
              // unique identifier generation failed
              // skip further processing, only decrease file count
              decreaseReamining();
            }
          );
        }else{
          // non-Promise provided as unique identifier, process synchronously
          addFile(uniqueIdentifier);
        }
      });
    };

    // INTERNAL OBJECT TYPES
    function ResumableFile(resumableObj, file, uniqueIdentifier){
      var $ = this;
      $.opts = {};
      $.getOpt = resumableObj.getOpt;
      $._prevProgress = 0;
      $.resumableObj = resumableObj;
      $.file = file;
      $.fileName = file.fileName||file.name; // Some confusion in different versions of Firefox
      $.size = file.size;
      $.relativePath = file.relativePath || file.webkitRelativePath || $.fileName;
      $.uniqueIdentifier = uniqueIdentifier;
      $._pause = false;
      $.container = '';
      var _error = uniqueIdentifier !== undefined;

      // Callback when something happens within the chunk
      var chunkEvent = function(event, message){
        // event can be 'progress', 'success', 'error' or 'retry'
        switch(event){
        case 'progress':
          $.resumableObj.fire('fileProgress', $);
          break;
        case 'error':
          $.abort();
          _error = true;
          $.chunks = [];
          $.resumableObj.fire('fileError', $, message);
          break;
        case 'success':
          if(_error) return;
          $.resumableObj.fire('fileProgress', $); // it's at least progress
          if($.isComplete()) {
            $.resumableObj.fire('fileSuccess', $, message);
          }
          break;
        case 'retry':
          $.resumableObj.fire('fileRetry', $);
          break;
        }
      };

      // Main code to set up a file object with chunks,
      // packaged to be able to handle retries if needed.
      $.chunks = [];
      $.abort = function(){
        // Stop current uploads
        var abortCount = 0;
        $h.each($.chunks, function(c){
          if(c.status()=='uploading') {
            c.abort();
            abortCount++;
          }
        });
        if(abortCount>0) $.resumableObj.fire('fileProgress', $);
      };
      $.cancel = function(){
        // Reset this file to be void
        var _chunks = $.chunks;
        $.chunks = [];
        // Stop current uploads
        $h.each(_chunks, function(c){
          if(c.status()=='uploading')  {
            c.abort();
            $.resumableObj.uploadNextChunk();
          }
        });
        $.resumableObj.removeFile($);
        $.resumableObj.fire('fileProgress', $);
      };
      $.retry = function(){
        $.bootstrap();
        var firedRetry = false;
        $.resumableObj.on('chunkingComplete', function(){
          if(!firedRetry) $.resumableObj.upload();
          firedRetry = true;
        });
      };
      $.bootstrap = function(){
        $.abort();
        _error = false;
        // Rebuild stack of chunks from file
        $.chunks = [];
        $._prevProgress = 0;
        var round = $.getOpt('forceChunkSize') ? Math.ceil : Math.floor;
        var maxOffset = Math.max(round($.file.size/$.getOpt('chunkSize')),1);
        for (var offset=0; offset<maxOffset; offset++) {(function(offset){
            window.setTimeout(function(){
                $.chunks.push(new ResumableChunk($.resumableObj, $, offset, chunkEvent));
                $.resumableObj.fire('chunkingProgress',$,offset/maxOffset);
            },0);
        })(offset)}
        window.setTimeout(function(){
            $.resumableObj.fire('chunkingComplete',$);
        },0);
      };
      $.progress = function(){
        if(_error) return(1);
        // Sum up progress across everything
        var ret = 0;
        var error = false;
        $h.each($.chunks, function(c){
          if(c.status()=='error') error = true;
          ret += c.progress(true); // get chunk progress relative to entire file
        });
        ret = (error ? 1 : (ret>0.99999 ? 1 : ret));
        ret = Math.max($._prevProgress, ret); // We don't want to lose percentages when an upload is paused
        $._prevProgress = ret;
        return(ret);
      };
      $.isUploading = function(){
        var uploading = false;
        $h.each($.chunks, function(chunk){
          if(chunk.status()=='uploading') {
            uploading = true;
            return(false);
          }
        });
        return(uploading);
      };
      $.isComplete = function(){
        var outstanding = false;
        $h.each($.chunks, function(chunk){
          var status = chunk.status();
          if(status=='pending' || status=='uploading' || chunk.preprocessState === 1) {
            outstanding = true;
            return(false);
          }
        });
        return(!outstanding);
      };
      $.pause = function(pause){
          if(typeof(pause)==='undefined'){
              $._pause = ($._pause ? false : true);
          }else{
              $._pause = pause;
          }
      };
      $.isPaused = function() {
        return $._pause;
      };


      // Bootstrap and return
      $.resumableObj.fire('chunkingStart', $);
      $.bootstrap();
      return(this);
    }


    function ResumableChunk(resumableObj, fileObj, offset, callback){
      var $ = this;
      $.opts = {};
      $.getOpt = resumableObj.getOpt;
      $.resumableObj = resumableObj;
      $.fileObj = fileObj;
      $.fileObjSize = fileObj.size;
      $.fileObjType = fileObj.file.type;
      $.offset = offset;
      $.callback = callback;
      $.lastProgressCallback = (new Date);
      $.tested = false;
      $.retries = 0;
      $.pendingRetry = false;
      $.preprocessState = 0; // 0 = unprocessed, 1 = processing, 2 = finished

      // Computed properties
      var chunkSize = $.getOpt('chunkSize');
      $.loaded = 0;
      $.startByte = $.offset*chunkSize;
      $.endByte = Math.min($.fileObjSize, ($.offset+1)*chunkSize);
      if ($.fileObjSize-$.endByte < chunkSize && !$.getOpt('forceChunkSize')) {
        // The last chunk will be bigger than the chunk size, but less than 2*chunkSize
        $.endByte = $.fileObjSize;
      }
      $.xhr = null;

      // test() makes a GET request without any data to see if the chunk has already been uploaded in a previous session
      $.test = function(){
        // Set up request and listen for event
        $.xhr = new XMLHttpRequest();

        var testHandler = function(e){
          $.tested = true;
          var status = $.status();
          if(status=='success') {
            $.callback(status, $.message());
            $.resumableObj.uploadNextChunk();
          } else {
            $.send();
          }
        };
        $.xhr.addEventListener('load', testHandler, false);
        $.xhr.addEventListener('error', testHandler, false);
        $.xhr.addEventListener('timeout', testHandler, false);

        // Add data from the query options
        var params = [];
        var parameterNamespace = $.getOpt('parameterNamespace');
        var customQuery = $.getOpt('query');
        if(typeof customQuery == 'function') customQuery = customQuery($.fileObj, $);
        $h.each(customQuery, function(k,v){
          params.push([encodeURIComponent(parameterNamespace+k), encodeURIComponent(v)].join('='));
        });
        // Add extra data to identify chunk
        params = params.concat(
          [
            // define key/value pairs for additional parameters
            ['chunkNumberParameterName', $.offset + 1],
            ['chunkSizeParameterName', $.getOpt('chunkSize')],
            ['currentChunkSizeParameterName', $.endByte - $.startByte],
            ['totalSizeParameterName', $.fileObjSize],
            ['typeParameterName', $.fileObjType],
            ['identifierParameterName', $.fileObj.uniqueIdentifier],
            ['fileNameParameterName', $.fileObj.fileName],
            ['relativePathParameterName', $.fileObj.relativePath],
            ['totalChunksParameterName', $.fileObj.chunks.length]
          ].filter(function(pair){
            // include items that resolve to truthy values
            // i.e. exclude false, null, undefined and empty strings
            return $.getOpt(pair[0]);
          })
          .map(function(pair){
            // map each key/value pair to its final form
            return [
              parameterNamespace + $.getOpt(pair[0]),
              encodeURIComponent(pair[1])
            ].join('=');
          })
        );
        // Append the relevant chunk and send it
        $.xhr.open($.getOpt('testMethod'), $h.getTarget('test', params));
        $.xhr.timeout = $.getOpt('xhrTimeout');
        $.xhr.withCredentials = $.getOpt('withCredentials');
        // Add data from header options
        var customHeaders = $.getOpt('headers');
        if(typeof customHeaders === 'function') {
          customHeaders = customHeaders($.fileObj, $);
        }
        $h.each(customHeaders, function(k,v) {
          $.xhr.setRequestHeader(k, v);
        });
        $.xhr.send(null);
      };

      $.preprocessFinished = function(){
        $.preprocessState = 2;
        $.send();
      };

      // send() uploads the actual data in a POST call
      $.send = function(){
        var preprocess = $.getOpt('preprocess');
        if(typeof preprocess === 'function') {
          switch($.preprocessState) {
          case 0: $.preprocessState = 1; preprocess($); return;
          case 1: return;
          case 2: break;
          }
        }
        if($.getOpt('testChunks') && !$.tested) {
          $.test();
          return;
        }

        // Set up request and listen for event
        $.xhr = new XMLHttpRequest();

        // Progress
        $.xhr.upload.addEventListener('progress', function(e){
          if( (new Date) - $.lastProgressCallback > $.getOpt('throttleProgressCallbacks') * 1000 ) {
            $.callback('progress');
            $.lastProgressCallback = (new Date);
          }
          $.loaded=e.loaded||0;
        }, false);
        $.loaded = 0;
        $.pendingRetry = false;
        $.callback('progress');

        // Done (either done, failed or retry)
        var doneHandler = function(e){
          var status = $.status();
          if(status=='success'||status=='error') {
            $.callback(status, $.message());
            $.resumableObj.uploadNextChunk();
          } else {
            $.callback('retry', $.message());
            $.abort();
            $.retries++;
            var retryInterval = $.getOpt('chunkRetryInterval');
            if(retryInterval !== undefined) {
              $.pendingRetry = true;
              setTimeout($.send, retryInterval);
            } else {
              $.send();
            }
          }
        };
        $.xhr.addEventListener('load', doneHandler, false);
        $.xhr.addEventListener('error', doneHandler, false);
        $.xhr.addEventListener('timeout', doneHandler, false);

        // Set up the basic query data from Resumable
        var query = [
          ['chunkNumberParameterName', $.offset + 1],
          ['chunkSizeParameterName', $.getOpt('chunkSize')],
          ['currentChunkSizeParameterName', $.endByte - $.startByte],
          ['totalSizeParameterName', $.fileObjSize],
          ['typeParameterName', $.fileObjType],
          ['identifierParameterName', $.fileObj.uniqueIdentifier],
          ['fileNameParameterName', $.fileObj.fileName],
          ['relativePathParameterName', $.fileObj.relativePath],
          ['totalChunksParameterName', $.fileObj.chunks.length],
        ].filter(function(pair){
          // include items that resolve to truthy values
          // i.e. exclude false, null, undefined and empty strings
          return $.getOpt(pair[0]);
        })
        .reduce(function(query, pair){
          // assign query key/value
          query[$.getOpt(pair[0])] = pair[1];
          return query;
        }, {});
        // Mix in custom data
        var customQuery = $.getOpt('query');
        if(typeof customQuery == 'function') customQuery = customQuery($.fileObj, $);
        $h.each(customQuery, function(k,v){
          query[k] = v;
        });

        var func = ($.fileObj.file.slice ? 'slice' : ($.fileObj.file.mozSlice ? 'mozSlice' : ($.fileObj.file.webkitSlice ? 'webkitSlice' : 'slice')));
        var bytes = $.fileObj.file[func]($.startByte, $.endByte);
        var data = null;
        var params = [];

        var parameterNamespace = $.getOpt('parameterNamespace');
        if ($.getOpt('method') === 'octet') {
          // Add data from the query options
          data = bytes;
          $h.each(query, function (k, v) {
            params.push([encodeURIComponent(parameterNamespace + k), encodeURIComponent(v)].join('='));
          });
        } else {
          // Add data from the query options
          data = new FormData();
          $h.each(query, function (k, v) {
            data.append(parameterNamespace + k, v);
            params.push([encodeURIComponent(parameterNamespace + k), encodeURIComponent(v)].join('='));
          });
          data.append(parameterNamespace + $.getOpt('fileParameterName'), bytes);
        }

        var target = $h.getTarget('upload', params);
        var method = $.getOpt('uploadMethod');

        $.xhr.open(method, target);
        if ($.getOpt('method') === 'octet') {
          $.xhr.setRequestHeader('Content-Type', 'application/octet-stream');
        }
        $.xhr.timeout = $.getOpt('xhrTimeout');
        $.xhr.withCredentials = $.getOpt('withCredentials');
        // Add data from header options
        var customHeaders = $.getOpt('headers');
        if(typeof customHeaders === 'function') {
          customHeaders = customHeaders($.fileObj, $);
        }

        $h.each(customHeaders, function(k,v) {
          $.xhr.setRequestHeader(k, v);
        });

        $.xhr.send(data);
      };
      $.abort = function(){
        // Abort and reset
        if($.xhr) $.xhr.abort();
        $.xhr = null;
      };
      $.status = function(){
        // Returns: 'pending', 'uploading', 'success', 'error'
        if($.pendingRetry) {
          // if pending retry then that's effectively the same as actively uploading,
          // there might just be a slight delay before the retry starts
          return('uploading');
        } else if(!$.xhr) {
          return('pending');
        } else if($.xhr.readyState<4) {
          // Status is really 'OPENED', 'HEADERS_RECEIVED' or 'LOADING' - meaning that stuff is happening
          return('uploading');
        } else {
          if($.xhr.status == 200 || $.xhr.status == 201) {
            // HTTP 200, 201 (created)
            return('success');
          } else if($h.contains($.getOpt('permanentErrors'), $.xhr.status) || $.retries >= $.getOpt('maxChunkRetries')) {
            // HTTP 415/500/501, permanent error
            return('error');
          } else {
            // this should never happen, but we'll reset and queue a retry
            // a likely case for this would be 503 service unavailable
            $.abort();
            return('pending');
          }
        }
      };
      $.message = function(){
        return($.xhr ? $.xhr.responseText : '');
      };
      $.progress = function(relative){
        if(typeof(relative)==='undefined') relative = false;
        var factor = (relative ? ($.endByte-$.startByte)/$.fileObjSize : 1);
        if($.pendingRetry) return(0);
        if(!$.xhr || !$.xhr.status) factor*=.95;
        var s = $.status();
        switch(s){
        case 'success':
        case 'error':
          return(1*factor);
        case 'pending':
          return(0*factor);
        default:
          return($.loaded/($.endByte-$.startByte)*factor);
        }
      };
      return(this);
    }

    // QUEUE
    $.uploadNextChunk = function(){
      var found = false;

      // In some cases (such as videos) it's really handy to upload the first
      // and last chunk of a file quickly; this let's the server check the file's
      // metadata and determine if there's even a point in continuing.
      if ($.getOpt('prioritizeFirstAndLastChunk')) {
        $h.each($.files, function(file){
          if(file.chunks.length && file.chunks[0].status()=='pending' && file.chunks[0].preprocessState === 0) {
            file.chunks[0].send();
            found = true;
            return(false);
          }
          if(file.chunks.length>1 && file.chunks[file.chunks.length-1].status()=='pending' && file.chunks[file.chunks.length-1].preprocessState === 0) {
            file.chunks[file.chunks.length-1].send();
            found = true;
            return(false);
          }
        });
        if(found) return(true);
      }

      // Now, simply look for the next, best thing to upload
      $h.each($.files, function(file){
        if(file.isPaused()===false){
         $h.each(file.chunks, function(chunk){
           if(chunk.status()=='pending' && chunk.preprocessState === 0) {
             chunk.send();
             found = true;
             return(false);
           }
          });
        }
        if(found) return(false);
      });
      if(found) return(true);

      // The are no more outstanding chunks to upload, check is everything is done
      var outstanding = false;
      $h.each($.files, function(file){
        if(!file.isComplete()) {
          outstanding = true;
          return(false);
        }
      });
      if(!outstanding) {
        // All chunks have been uploaded, complete
        $.fire('complete');
      }
      return(false);
    };


    // PUBLIC METHODS FOR RESUMABLE.JS
    $.assignBrowse = function(domNodes, isDirectory){
      if(typeof(domNodes.length)=='undefined') domNodes = [domNodes];

      $h.each(domNodes, function(domNode) {
        var input;
        if(domNode.tagName==='INPUT' && domNode.type==='file'){
          input = domNode;
        } else {
          input = document.createElement('input');
          input.setAttribute('type', 'file');
          input.style.display = 'none';
          domNode.addEventListener('click', function(){
            input.style.opacity = 0;
            input.style.display='block';
            input.focus();
            input.click();
            input.style.display='none';
          }, false);
          domNode.appendChild(input);
        }
        var maxFiles = $.getOpt('maxFiles');
        if (typeof(maxFiles)==='undefined'||maxFiles!=1){
          input.setAttribute('multiple', 'multiple');
        } else {
          input.removeAttribute('multiple');
        }
        if(isDirectory){
          input.setAttribute('webkitdirectory', 'webkitdirectory');
        } else {
          input.removeAttribute('webkitdirectory');
        }
        // When new files are added, simply append them to the overall list
        input.addEventListener('change', function(e){
          appendFilesFromFileList(e.target.files,e);
          var clearInput = $.getOpt('clearInput');
          if (clearInput) {
            e.target.value = '';
          }
        }, false);
      });
    };
    $.assignDrop = function(domNodes){
      if(typeof(domNodes.length)=='undefined') domNodes = [domNodes];

      $h.each(domNodes, function(domNode) {
        domNode.addEventListener('dragover', preventDefault, false);
        domNode.addEventListener('dragenter', preventDefault, false);
        domNode.addEventListener('drop', onDrop, false);
      });
    };
    $.unAssignDrop = function(domNodes) {
      if (typeof(domNodes.length) == 'undefined') domNodes = [domNodes];

      $h.each(domNodes, function(domNode) {
        domNode.removeEventListener('dragover', preventDefault);
        domNode.removeEventListener('dragenter', preventDefault);
        domNode.removeEventListener('drop', onDrop);
      });
    };
    $.isUploading = function(){
      var uploading = false;
      $h.each($.files, function(file){
        if (file.isUploading()) {
          uploading = true;
          return(false);
        }
      });
      return(uploading);
    };
    $.upload = function(){
      // Make sure we don't start too many uploads at once
      if($.isUploading()) return;
      // Kick off the queue
      $.fire('uploadStart');
      for (var num=1; num<=$.getOpt('simultaneousUploads'); num++) {
        $.uploadNextChunk();
      }
    };
    $.pause = function(){
      // Resume all chunks currently being uploaded
      $h.each($.files, function(file){
        file.abort();
      });
      $.fire('pause');
    };
    $.cancel = function(){
      $.fire('beforeCancel');
      for(var i = $.files.length - 1; i >= 0; i--) {
        $.files[i].cancel();
      }
      $.fire('cancel');
    };
    $.progress = function(){
      var totalDone = 0;
      var totalSize = 0;
      // Resume all chunks currently being uploaded
      $h.each($.files, function(file){
        totalDone += file.progress()*file.size;
        totalSize += file.size;
      });
      return(totalSize>0 ? totalDone/totalSize : 0);
    };
    $.addFile = function(file, event){
      appendFilesFromFileList([file], event);
    };
    $.removeFile = function(file){
      for(var i = $.files.length - 1; i >= 0; i--) {
        if($.files[i] === file) {
          $.files.splice(i, 1);
        }
      }
    };
    $.getFromUniqueIdentifier = function(uniqueIdentifier){
      var ret = false;
      $h.each($.files, function(f){
        if(f.uniqueIdentifier==uniqueIdentifier) ret = f;
      });
      return(ret);
    };
    $.getSize = function(){
      var totalSize = 0;
      $h.each($.files, function(file){
        totalSize += file.size;
      });
      return(totalSize);
    };
    $.handleDropEvent = function (e) {
      onDrop(e);
    };
    $.handleChangeEvent = function (e) {
      appendFilesFromFileList(e.target.files, e);
      e.target.value = '';
    };
    $.updateQuery = function(query){
        $.opts.query = query;
    };

    return(this);
  };


  // Node.js-style export for Node and Component
  if (typeof module != 'undefined') {
    module.exports = Resumable;
  } else if (typeof define === "function" && define.amd) {
    // AMD/requirejs: Define the module
    define(function(){
      return Resumable;
    });
  } else {
    // Browser: Expose to window
    window.Resumable = Resumable;
  }

})();
