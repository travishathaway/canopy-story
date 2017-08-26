/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/upload.js":
/***/ (function(module, exports) {

CHUNK_SIZE = 1 * Math.pow(2, 20); // roughly 1mb

function getUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : r & 0x3 | 0x8;
        return v.toString(16);
    });
}

// init the resumable file object
var r = new Resumable({
    target: "/post/image",
    testChunks: false,
    maxChunkRetries: 3,
    chunkRetryInterval: 1000,
    generateUniqueIdentifier: getUUID,
    chunkSize: CHUNK_SIZE,
    query: { "main_file_slug": window.location.toString().replace(/\/$/, '').split("/").pop() }
});

// update the progress bar
r.on('progress', function () {
    var percent = Math.ceil(this.progress() * 100) + "%";
    $('#progress-bar').css('width', percent);
    $('#progress-bar').text(percent);
});

// when a new file is added, list it in the dropbox area
r.on('fileAdded', listFiles);

// if there is a problem uploading a file, we just quit and submit the form
// with the error listed
r.on('fileError', function (file, message) {
    $('#error-message').val(message);
    $('#form').submit();
    r.cancel();
});

r.on('complete', function () {
    var valid_names = [];
    var filename_inputs = [];

    for (var x = 0; x < r.files.length; x++) {
        var uuid = r.files[x].uniqueIdentifier;
        var filename = r.files[x].fileName;
        var full_name = uuid + filename;
        var input = $("<input>").attr({
            "id": "image-filepath-" + x,
            "type": "hidden",
            "name": "image-filepath[]"
        }).val(full_name);

        filename_inputs.push(input);

        valid_names.push(accept(filename));
    }

    var valid = valid_names.every(function (x) {
        if (x === true) {
            return true;
        }
    });

    if (valid) {
        $("#form").append(filename_inputs);
        // we delay this a bit so the progress bar is updated to 100%
        setTimeout(function () {
            $('#form').submit();
        }, 1000);
    } else {
        document.cookie = "message=ERROR: Files of that type are not allowed. Post was not submitted; expires=" + Date.now() + 10 + "; path=/";
        window.location = '/list';
    }
});

function listFiles() {
    var html = ["<ul>"];
    for (var i = 0; i < r.files.length; i++) {
        html.push("<li><span data-index='" + i + "' class='remove-file glyphicon glyphicon-remove'></span>" + r.files[i].fileName + "</li>");
    }
    html.push("</ul>");
    $('#dropbox').html(html.join(""));
}

function dropbox() {
    if ($('#popup').is(":visible")) {
        $('#popup').ready(function () {
            // init these DOM objects for the file upload
            r.assignBrowse(document.getElementById("file"));
            r.assignDrop(document.getElementById("dropbox"));
            // start the upload process
        });
    } else {
        setTimeout(function () {
            dropbox();
        }, 50);
    }

    $('#submit-treestory').on("click", function (e) {
        if (r.files.length > 0) {
            r.upload();
            $(this).hide();
            $(".progress").show();
        } else {
            $("#form").submit();
        }
    });

    $('.leaflet-popup-close-button').click(function () {
        dropbox();
    });

    $('#dropbox').on("click", function (e) {
        $('#file').click();
    });

    $('#dropbox').on('click', '.remove-file', function (e) {
        e.stopPropagation();
        var index = parseInt($(this).data("index"));
        r.removeFile(r.files[index]);
        listFiles();
    });
}
dropbox();

var accepted_filetypes = ['jpg', 'png', 'gif', 'jpeg', 'bmp'];

function accept(filename) {
    var ext = filename.split('.').pop().toLowerCase();
    if (accepted_filetypes.indexOf(ext) == -1) {
        return false;
    }
    return true;
}

/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/upload.js");


/***/ })

/******/ });