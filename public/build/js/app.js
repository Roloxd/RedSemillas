/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var cropperjs__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! cropperjs */ "./node_modules/cropperjs/dist/cropper.js");
/* harmony import */ var cropperjs__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(cropperjs__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _vendor_presta_image_bundle_Resources_public_js_cropper__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../vendor/presta/image-bundle/Resources/public/js/cropper */ "./vendor/presta/image-bundle/Resources/public/js/cropper.js");
/* harmony import */ var _vendor_presta_image_bundle_Resources_public_js_cropper__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_vendor_presta_image_bundle_Resources_public_js_cropper__WEBPACK_IMPORTED_MODULE_3__);




jquery__WEBPACK_IMPORTED_MODULE_1___default()(function () {
  console.log('WEBPACK CROPPER');
  jquery__WEBPACK_IMPORTED_MODULE_1___default()('.cropper').each(function () {
    new _vendor_presta_image_bundle_Resources_public_js_cropper__WEBPACK_IMPORTED_MODULE_3__(jquery__WEBPACK_IMPORTED_MODULE_1___default()(this));
  });
});

/***/ }),

/***/ "./vendor/presta/image-bundle/Resources/public/js/cropper.js":
/*!*******************************************************************!*\
  !*** ./vendor/presta/image-bundle/Resources/public/js/cropper.js ***!
  \*******************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/* module decorator */ module = __webpack_require__.nmd(module);
/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");

__webpack_require__(/*! core-js/modules/es.array.index-of.js */ "./node_modules/core-js/modules/es.array.index-of.js");

var CropperJS = __webpack_require__(/*! cropperjs */ "./node_modules/cropperjs/dist/cropper.js");

(function (w, $) {
  'use strict';

  var Cropper = function Cropper($el) {
    this.$el = $el;
    this.options = $.extend({}, $el.data('cropper-options'));
    this.initElements().initLocalEvents().initRemoteEvents().initCroppingEvents();
  };

  Cropper.prototype.initElements = function () {
    this.$modal = this.$el.find('.modal');
    this.$aspectRatio = this.$modal.find('input[name="cropperAspectRatio"]');
    this.$rotator = this.$modal.find('.rotate');
    this.$input = this.$el.find('input.cropper-base64');
    this.$container = {
      $preview: this.$modal.find('.cropper-preview'),
      $canvas: this.$el.find('.cropper-canvas-container')
    };
    this.$local = {
      $btnUpload: this.$el.find('.cropper-local button'),
      $input: this.$el.find('.cropper-local input[type="file"]')
    };
    this.$remote = {
      $btnUpload: this.$el.find('.cropper-remote button'),
      $uploadLoader: this.$el.find('.cropper-remote .remote-loader'),
      $input: this.$el.find('.cropper-remote input[type="url"]')
    };
    this.options = $.extend(this.options, {
      aspectRatio: this.$aspectRatio.val()
    });
    this.cropper = null;
    return this;
  };

  Cropper.prototype.initLocalEvents = function () {
    var self = this; // map virtual upload button to native input file element

    this.$local.$btnUpload.on('click', function () {
      self.$local.$input.trigger('click');
    }); // start cropping process on input file "change"

    this.$local.$input.on('change', function () {
      var reader = new FileReader(); // show a croppable preview image in a modal

      reader.onload = function (e) {
        self.prepareCropping(e.target.result); // clear input file so that user can select the same image twice and the "change" event keeps being triggered

        self.$local.$input.val('');
      }; // trigger "reader.onload" with uploaded file


      reader.readAsDataURL(this.files[0]);
    });
    return this;
  };

  Cropper.prototype.initRemoteEvents = function () {
    var self = this;
    var $btnUpload = this.$remote.$btnUpload;
    var $uploadLoader = this.$remote.$uploadLoader; // handle distant image upload button state

    this.$remote.$input.on('change, input', function () {
      var url = $(this).val();
      self.$remote.$btnUpload.prop('disabled', url.length <= 0 || url.indexOf('http') === -1);
    }); // start cropping process get image's base64 representation from local server to avoid cross-domain issues

    this.$remote.$btnUpload.on('click', function () {
      $btnUpload.hide();
      $uploadLoader.removeClass('hidden d-none');
      $.ajax({
        url: $btnUpload.data('url'),
        data: {
          url: self.$remote.$input.val()
        },
        method: 'post'
      }).done(function (data) {
        self.prepareCropping(data.base64);
        $btnUpload.show();
        $uploadLoader.addClass('hidden d-none');
      });
    });
    return this;
  };

  Cropper.prototype.initCroppingEvents = function () {
    var self = this; // handle image cropping

    this.$modal.find('[data-method="getCroppedCanvas"]').on('click', function () {
      self.crop();
    }); // handle "aspectRatio" switch

    this.$aspectRatio.on('change', function () {
      self.cropper.setAspectRatio($(this).val());
    });
    this.$rotator.on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      self.cropper.rotate($(this).data('rotate'));
    });
    return this;
  };
  /**
   * Open cropper "editor" in a modal with the base64 uploaded image.
   */


  Cropper.prototype.prepareCropping = function (base64) {
    var self = this; // clean previous croppable image

    if (this.cropper) {
      this.cropper.destroy();
      this.$container.$preview.children('img').remove();
    } // reset "aspectRatio" buttons


    this.$aspectRatio.each(function () {
      var $this = $(this);

      if ($this.val().length <= 0) {
        $this.trigger('click');
      }
    });
    this.$modal.one('shown.bs.modal', function () {
      // (re)build croppable image once the modal is shown (required to get proper image width)
      $('<img>').attr('src', base64).on('load', function () {
        self.cropper = new CropperJS(this, self.options);
      }).appendTo(self.$container.$preview);
    }).modal('show');
  };
  /**
   * Create canvas from cropped image and fill in the hidden input with canvas base64 data.
   */


  Cropper.prototype.crop = function () {
    var data = this.cropper.getData(),
        image_width = Math.min(this.$el.data('max-width'), data.width),
        image_height = Math.min(this.$el.data('max-height'), data.height),
        preview_width = Math.min(this.$container.$canvas.data('preview-width'), data.width),
        preview_height = Math.min(this.$container.$canvas.data('preview-height'), data.height),
        // TODO: getCroppedCanvas seams to only consider one dimension when calculating the maximum size
    // in respect to the aspect ratio and always considers width first, so height is basically ignored!
    // To set a maximum height, no width parameter should be set.
    // Example of current wrong behavior:
    // source of 200x300 with resize to 150x200 results in 150x225 => WRONG (should be: 133x200)
    // source of 200x300 with resize to 200x150 results in 200x300 => WRONG (should be: 100x150)
    // This is an issue with cropper, not this library
    preview_canvas = this.cropper.getCroppedCanvas({
      width: preview_width,
      height: preview_height
    }),
        image_canvas = this.cropper.getCroppedCanvas({
      width: image_width,
      height: image_height
    }); // fill canvas preview container with cropped image

    this.$container.$canvas.html(preview_canvas); // fill input with base64 cropped image

    this.$input.val(image_canvas.toDataURL(this.$el.data('mimetype'), this.$el.data('quality'))); // hide the modal

    this.$modal.modal('hide');
  };

  if ( true && 'exports' in module) {
    module.exports = Cropper;
  } else {
    window.Cropper = Cropper;
  }
})(window, jQuery);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			loaded: false,
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/node module decorator */
/******/ 	(() => {
/******/ 		__webpack_require__.nmd = (module) => {
/******/ 			module.paths = [];
/******/ 			if (!module.children) module.children = [];
/******/ 			return module;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"js/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["vendors-node_modules_bootstrap_dist_js_bootstrap_js-node_modules_core-js_modules_es_array_fin-c115b3"], () => (__webpack_require__("./assets/js/app.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYXBwLmpzIiwid2VicGFjazovLy8uL3ZlbmRvci9wcmVzdGEvaW1hZ2UtYnVuZGxlL1Jlc291cmNlcy9wdWJsaWMvanMvY3JvcHBlci5qcyIsIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9jaHVuayBsb2FkZWQiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9jb21wYXQgZ2V0IGRlZmF1bHQgZXhwb3J0Iiwid2VicGFjazovLy93ZWJwYWNrL3J1bnRpbWUvZGVmaW5lIHByb3BlcnR5IGdldHRlcnMiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9nbG9iYWwiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9oYXNPd25Qcm9wZXJ0eSBzaG9ydGhhbmQiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9ub2RlIG1vZHVsZSBkZWNvcmF0b3IiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9qc29ucCBjaHVuayBsb2FkaW5nIiwid2VicGFjazovLy93ZWJwYWNrL3N0YXJ0dXAiXSwibmFtZXMiOlsiJCIsImNvbnNvbGUiLCJsb2ciLCJlYWNoIiwiQ3JvcHBlciIsIkNyb3BwZXJKUyIsInJlcXVpcmUiLCJ3IiwiJGVsIiwib3B0aW9ucyIsImV4dGVuZCIsImRhdGEiLCJpbml0RWxlbWVudHMiLCJpbml0TG9jYWxFdmVudHMiLCJpbml0UmVtb3RlRXZlbnRzIiwiaW5pdENyb3BwaW5nRXZlbnRzIiwicHJvdG90eXBlIiwiJG1vZGFsIiwiZmluZCIsIiRhc3BlY3RSYXRpbyIsIiRyb3RhdG9yIiwiJGlucHV0IiwiJGNvbnRhaW5lciIsIiRwcmV2aWV3IiwiJGNhbnZhcyIsIiRsb2NhbCIsIiRidG5VcGxvYWQiLCIkcmVtb3RlIiwiJHVwbG9hZExvYWRlciIsImFzcGVjdFJhdGlvIiwidmFsIiwiY3JvcHBlciIsInNlbGYiLCJvbiIsInRyaWdnZXIiLCJyZWFkZXIiLCJGaWxlUmVhZGVyIiwib25sb2FkIiwiZSIsInByZXBhcmVDcm9wcGluZyIsInRhcmdldCIsInJlc3VsdCIsInJlYWRBc0RhdGFVUkwiLCJmaWxlcyIsInVybCIsInByb3AiLCJsZW5ndGgiLCJpbmRleE9mIiwiaGlkZSIsInJlbW92ZUNsYXNzIiwiYWpheCIsIm1ldGhvZCIsImRvbmUiLCJiYXNlNjQiLCJzaG93IiwiYWRkQ2xhc3MiLCJjcm9wIiwic2V0QXNwZWN0UmF0aW8iLCJwcmV2ZW50RGVmYXVsdCIsInN0b3BQcm9wYWdhdGlvbiIsInJvdGF0ZSIsImRlc3Ryb3kiLCJjaGlsZHJlbiIsInJlbW92ZSIsIiR0aGlzIiwib25lIiwiYXR0ciIsImFwcGVuZFRvIiwibW9kYWwiLCJnZXREYXRhIiwiaW1hZ2Vfd2lkdGgiLCJNYXRoIiwibWluIiwid2lkdGgiLCJpbWFnZV9oZWlnaHQiLCJoZWlnaHQiLCJwcmV2aWV3X3dpZHRoIiwicHJldmlld19oZWlnaHQiLCJwcmV2aWV3X2NhbnZhcyIsImdldENyb3BwZWRDYW52YXMiLCJpbWFnZV9jYW52YXMiLCJodG1sIiwidG9EYXRhVVJMIiwibW9kdWxlIiwiZXhwb3J0cyIsIndpbmRvdyIsImpRdWVyeSJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBRUFBLDZDQUFDLENBQUMsWUFBVztBQUNUQyxTQUFPLENBQUNDLEdBQVIsQ0FBWSxpQkFBWjtBQUNBRiwrQ0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjRyxJQUFkLENBQW1CLFlBQVc7QUFDMUIsUUFBSUMsb0ZBQUosQ0FBWUosNkNBQUMsQ0FBQyxJQUFELENBQWI7QUFDSCxHQUZEO0FBR0gsQ0FMQSxDQUFELEM7Ozs7Ozs7Ozs7Ozs7Ozs7QUNMQSxJQUFNSyxTQUFTLEdBQUdDLG1CQUFPLENBQUMsMkRBQUQsQ0FBekI7O0FBRUEsQ0FBQyxV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O1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBOztXQUVBO1dBQ0E7V0FDQSw0Rzs7Ozs7VUM5Q0E7VUFDQTtVQUNBO1VBQ0E7VUFDQSIsImZpbGUiOiJqcy9hcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgJ2Jvb3RzdHJhcCc7XG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0ICdjcm9wcGVyanMnO1xuaW1wb3J0ICogYXMgQ3JvcHBlciBmcm9tICcuLi8uLi92ZW5kb3IvcHJlc3RhL2ltYWdlLWJ1bmRsZS9SZXNvdXJjZXMvcHVibGljL2pzL2Nyb3BwZXInO1xuXG4kKGZ1bmN0aW9uKCkge1xuICAgIGNvbnNvbGUubG9nKCdXRUJQQUNLIENST1BQRVInKTtcbiAgICAkKCcuY3JvcHBlcicpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgIG5ldyBDcm9wcGVyKCQodGhpcykpO1xuICAgIH0pO1xufSk7XG5cblxuXG4iLCJjb25zdCBDcm9wcGVySlMgPSByZXF1aXJlKCdjcm9wcGVyanMnKTtcblxuKGZ1bmN0aW9uKHcsICQpIHtcblxuICAgICd1c2Ugc3RyaWN0JztcblxuICAgIGNvbnN0IENyb3BwZXIgPSBmdW5jdGlvbigkZWwpIHtcbiAgICAgICAgdGhpcy4kZWwgPSAkZWw7XG4gICAgICAgIHRoaXMub3B0aW9ucyA9ICQuZXh0ZW5kKHt9LCAkZWwuZGF0YSgnY3JvcHBlci1vcHRpb25zJykpO1xuXG4gICAgICAgIHRoaXNcbiAgICAgICAgICAgIC5pbml0RWxlbWVudHMoKVxuICAgICAgICAgICAgLmluaXRMb2NhbEV2ZW50cygpXG4gICAgICAgICAgICAuaW5pdFJlbW90ZUV2ZW50cygpXG4gICAgICAgICAgICAuaW5pdENyb3BwaW5nRXZlbnRzKClcbiAgICAgICAgO1xuICAgIH07XG5cbiAgICBDcm9wcGVyLnByb3RvdHlwZS5pbml0RWxlbWVudHMgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgdGhpcy4kbW9kYWwgPSB0aGlzLiRlbC5maW5kKCcubW9kYWwnKTtcbiAgICAgICAgdGhpcy4kYXNwZWN0UmF0aW8gPSB0aGlzLiRtb2RhbC5maW5kKCdpbnB1dFtuYW1lPVwiY3JvcHBlckFzcGVjdFJhdGlvXCJdJyk7XG4gICAgICAgIHRoaXMuJHJvdGF0b3IgPSB0aGlzLiRtb2RhbC5maW5kKCcucm90YXRlJyk7XG4gICAgICAgIHRoaXMuJGlucHV0ID0gdGhpcy4kZWwuZmluZCgnaW5wdXQuY3JvcHBlci1iYXNlNjQnKTtcblxuICAgICAgICB0aGlzLiRjb250YWluZXIgPSB7XG4gICAgICAgICAgICAkcHJldmlldzogdGhpcy4kbW9kYWwuZmluZCgnLmNyb3BwZXItcHJldmlldycpLFxuICAgICAgICAgICAgJGNhbnZhczogdGhpcy4kZWwuZmluZCgnLmNyb3BwZXItY2FudmFzLWNvbnRhaW5lcicpXG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy4kbG9jYWwgPSB7XG4gICAgICAgICAgICAkYnRuVXBsb2FkOiB0aGlzLiRlbC5maW5kKCcuY3JvcHBlci1sb2NhbCBidXR0b24nKSxcbiAgICAgICAgICAgICRpbnB1dDogdGhpcy4kZWwuZmluZCgnLmNyb3BwZXItbG9jYWwgaW5wdXRbdHlwZT1cImZpbGVcIl0nKVxuICAgICAgICB9O1xuXG4gICAgICAgIHRoaXMuJHJlbW90ZSA9IHtcbiAgICAgICAgICAgICRidG5VcGxvYWQ6IHRoaXMuJGVsLmZpbmQoJy5jcm9wcGVyLXJlbW90ZSBidXR0b24nKSxcbiAgICAgICAgICAgICR1cGxvYWRMb2FkZXI6IHRoaXMuJGVsLmZpbmQoJy5jcm9wcGVyLXJlbW90ZSAucmVtb3RlLWxvYWRlcicpLFxuICAgICAgICAgICAgJGlucHV0OiB0aGlzLiRlbC5maW5kKCcuY3JvcHBlci1yZW1vdGUgaW5wdXRbdHlwZT1cInVybFwiXScpXG4gICAgICAgIH07XG5cbiAgICAgICAgdGhpcy5vcHRpb25zID0gJC5leHRlbmQodGhpcy5vcHRpb25zLCB7XG4gICAgICAgICAgICBhc3BlY3RSYXRpbzogdGhpcy4kYXNwZWN0UmF0aW8udmFsKClcbiAgICAgICAgfSk7XG5cbiAgICAgICAgdGhpcy5jcm9wcGVyID0gbnVsbDtcblxuICAgICAgICByZXR1cm4gdGhpcztcbiAgICB9O1xuXG4gICAgQ3JvcHBlci5wcm90b3R5cGUuaW5pdExvY2FsRXZlbnRzID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIGNvbnN0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIC8vIG1hcCB2aXJ0dWFsIHVwbG9hZCBidXR0b24gdG8gbmF0aXZlIGlucHV0IGZpbGUgZWxlbWVudFxuICAgICAgICB0aGlzLiRsb2NhbC4kYnRuVXBsb2FkLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgc2VsZi4kbG9jYWwuJGlucHV0LnRyaWdnZXIoJ2NsaWNrJyk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIC8vIHN0YXJ0IGNyb3BwaW5nIHByb2Nlc3Mgb24gaW5wdXQgZmlsZSBcImNoYW5nZVwiXG4gICAgICAgIHRoaXMuJGxvY2FsLiRpbnB1dC5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBjb25zdCByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuXG4gICAgICAgICAgICAvLyBzaG93IGEgY3JvcHBhYmxlIHByZXZpZXcgaW1hZ2UgaW4gYSBtb2RhbFxuICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICBzZWxmLnByZXBhcmVDcm9wcGluZyhlLnRhcmdldC5yZXN1bHQpO1xuXG4gICAgICAgICAgICAgICAgLy8gY2xlYXIgaW5wdXQgZmlsZSBzbyB0aGF0IHVzZXIgY2FuIHNlbGVjdCB0aGUgc2FtZSBpbWFnZSB0d2ljZSBhbmQgdGhlIFwiY2hhbmdlXCIgZXZlbnQga2VlcHMgYmVpbmcgdHJpZ2dlcmVkXG4gICAgICAgICAgICAgICAgc2VsZi4kbG9jYWwuJGlucHV0LnZhbCgnJyk7XG4gICAgICAgICAgICB9O1xuXG4gICAgICAgICAgICAvLyB0cmlnZ2VyIFwicmVhZGVyLm9ubG9hZFwiIHdpdGggdXBsb2FkZWQgZmlsZVxuICAgICAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwodGhpcy5maWxlc1swXSk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIHJldHVybiB0aGlzO1xuICAgIH07XG5cbiAgICBDcm9wcGVyLnByb3RvdHlwZS5pbml0UmVtb3RlRXZlbnRzID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIGNvbnN0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIGNvbnN0ICRidG5VcGxvYWQgPSB0aGlzLiRyZW1vdGUuJGJ0blVwbG9hZDtcbiAgICAgICAgY29uc3QgJHVwbG9hZExvYWRlciA9IHRoaXMuJHJlbW90ZS4kdXBsb2FkTG9hZGVyO1xuXG4gICAgICAgIC8vIGhhbmRsZSBkaXN0YW50IGltYWdlIHVwbG9hZCBidXR0b24gc3RhdGVcbiAgICAgICAgdGhpcy4kcmVtb3RlLiRpbnB1dC5vbignY2hhbmdlLCBpbnB1dCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgY29uc3QgdXJsID0gJCh0aGlzKS52YWwoKTtcblxuICAgICAgICAgICAgc2VsZi4kcmVtb3RlLiRidG5VcGxvYWQucHJvcCgnZGlzYWJsZWQnLCB1cmwubGVuZ3RoIDw9IDAgfHwgdXJsLmluZGV4T2YoJ2h0dHAnKSA9PT0gLTEpO1xuICAgICAgICB9KTtcblxuICAgICAgICAvLyBzdGFydCBjcm9wcGluZyBwcm9jZXNzIGdldCBpbWFnZSdzIGJhc2U2NCByZXByZXNlbnRhdGlvbiBmcm9tIGxvY2FsIHNlcnZlciB0byBhdm9pZCBjcm9zcy1kb21haW4gaXNzdWVzXG4gICAgICAgIHRoaXMuJHJlbW90ZS4kYnRuVXBsb2FkLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgJGJ0blVwbG9hZC5oaWRlKCk7XG4gICAgICAgICAgICAkdXBsb2FkTG9hZGVyLnJlbW92ZUNsYXNzKCdoaWRkZW4gZC1ub25lJyk7XG4gICAgICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgICAgIHVybDogJGJ0blVwbG9hZC5kYXRhKCd1cmwnKSxcbiAgICAgICAgICAgICAgICBkYXRhOiB7XG4gICAgICAgICAgICAgICAgICAgIHVybDogc2VsZi4kcmVtb3RlLiRpbnB1dC52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgbWV0aG9kOiAncG9zdCdcbiAgICAgICAgICAgIH0pLmRvbmUoZnVuY3Rpb24oZGF0YSkge1xuICAgICAgICAgICAgICAgIHNlbGYucHJlcGFyZUNyb3BwaW5nKGRhdGEuYmFzZTY0KTtcbiAgICAgICAgICAgICAgICAkYnRuVXBsb2FkLnNob3coKTtcbiAgICAgICAgICAgICAgICAkdXBsb2FkTG9hZGVyLmFkZENsYXNzKCdoaWRkZW4gZC1ub25lJyk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgcmV0dXJuIHRoaXM7XG4gICAgfTtcblxuICAgIENyb3BwZXIucHJvdG90eXBlLmluaXRDcm9wcGluZ0V2ZW50cyA9IGZ1bmN0aW9uKCkge1xuICAgICAgICBjb25zdCBzZWxmID0gdGhpcztcblxuICAgICAgICAvLyBoYW5kbGUgaW1hZ2UgY3JvcHBpbmdcbiAgICAgICAgdGhpcy4kbW9kYWwuZmluZCgnW2RhdGEtbWV0aG9kPVwiZ2V0Q3JvcHBlZENhbnZhc1wiXScpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgc2VsZi5jcm9wKCk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIC8vIGhhbmRsZSBcImFzcGVjdFJhdGlvXCIgc3dpdGNoXG4gICAgICAgIHRoaXMuJGFzcGVjdFJhdGlvLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIHNlbGYuY3JvcHBlci5zZXRBc3BlY3RSYXRpbygkKHRoaXMpLnZhbCgpKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgdGhpcy4kcm90YXRvci5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuXG4gICAgICAgICAgICBzZWxmLmNyb3BwZXIucm90YXRlKCQodGhpcykuZGF0YSgncm90YXRlJykpO1xuICAgICAgICB9KTtcblxuICAgICAgICByZXR1cm4gdGhpcztcbiAgICB9O1xuXG4gICAgLyoqXG4gICAgICogT3BlbiBjcm9wcGVyIFwiZWRpdG9yXCIgaW4gYSBtb2RhbCB3aXRoIHRoZSBiYXNlNjQgdXBsb2FkZWQgaW1hZ2UuXG4gICAgICovXG4gICAgQ3JvcHBlci5wcm90b3R5cGUucHJlcGFyZUNyb3BwaW5nID0gZnVuY3Rpb24oYmFzZTY0KSB7XG4gICAgICAgIGNvbnN0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIC8vIGNsZWFuIHByZXZpb3VzIGNyb3BwYWJsZSBpbWFnZVxuICAgICAgICBpZiAodGhpcy5jcm9wcGVyKSB7XG4gICAgICAgICAgICB0aGlzLmNyb3BwZXIuZGVzdHJveSgpO1xuICAgICAgICAgICAgdGhpcy4kY29udGFpbmVyLiRwcmV2aWV3LmNoaWxkcmVuKCdpbWcnKS5yZW1vdmUoKTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIHJlc2V0IFwiYXNwZWN0UmF0aW9cIiBidXR0b25zXG4gICAgICAgIHRoaXMuJGFzcGVjdFJhdGlvLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBjb25zdCAkdGhpcyA9ICQodGhpcyk7XG5cbiAgICAgICAgICAgIGlmICgkdGhpcy52YWwoKS5sZW5ndGggPD0gMCkge1xuICAgICAgICAgICAgICAgICR0aGlzLnRyaWdnZXIoJ2NsaWNrJyk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuXG4gICAgICAgIHRoaXMuJG1vZGFsXG4gICAgICAgICAgICAub25lKCdzaG93bi5icy5tb2RhbCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIC8vIChyZSlidWlsZCBjcm9wcGFibGUgaW1hZ2Ugb25jZSB0aGUgbW9kYWwgaXMgc2hvd24gKHJlcXVpcmVkIHRvIGdldCBwcm9wZXIgaW1hZ2Ugd2lkdGgpXG4gICAgICAgICAgICAgICAgJCgnPGltZz4nKVxuICAgICAgICAgICAgICAgICAgICAuYXR0cignc3JjJywgYmFzZTY0KVxuICAgICAgICAgICAgICAgICAgICAub24oJ2xvYWQnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHNlbGYuY3JvcHBlciA9IG5ldyBDcm9wcGVySlModGhpcywgc2VsZi5vcHRpb25zKVxuICAgICAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kVG8oc2VsZi4kY29udGFpbmVyLiRwcmV2aWV3KTtcbiAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAubW9kYWwoJ3Nob3cnKVxuICAgICAgICA7XG4gICAgfTtcblxuICAgIC8qKlxuICAgICAqIENyZWF0ZSBjYW52YXMgZnJvbSBjcm9wcGVkIGltYWdlIGFuZCBmaWxsIGluIHRoZSBoaWRkZW4gaW5wdXQgd2l0aCBjYW52YXMgYmFzZTY0IGRhdGEuXG4gICAgICovXG4gICAgQ3JvcHBlci5wcm90b3R5cGUuY3JvcCA9IGZ1bmN0aW9uKCkge1xuICAgICAgICBjb25zdCBkYXRhID0gdGhpcy5jcm9wcGVyLmdldERhdGEoKSxcbiAgICAgICAgICAgIGltYWdlX3dpZHRoID0gTWF0aC5taW4odGhpcy4kZWwuZGF0YSgnbWF4LXdpZHRoJyksIGRhdGEud2lkdGgpLFxuICAgICAgICAgICAgaW1hZ2VfaGVpZ2h0ID0gTWF0aC5taW4odGhpcy4kZWwuZGF0YSgnbWF4LWhlaWdodCcpLCBkYXRhLmhlaWdodCksXG4gICAgICAgICAgICBwcmV2aWV3X3dpZHRoID0gTWF0aC5taW4odGhpcy4kY29udGFpbmVyLiRjYW52YXMuZGF0YSgncHJldmlldy13aWR0aCcpLCBkYXRhLndpZHRoKSxcbiAgICAgICAgICAgIHByZXZpZXdfaGVpZ2h0ID0gTWF0aC5taW4odGhpcy4kY29udGFpbmVyLiRjYW52YXMuZGF0YSgncHJldmlldy1oZWlnaHQnKSwgZGF0YS5oZWlnaHQpLFxuXG4gICAgICAgICAgICAvLyBUT0RPOiBnZXRDcm9wcGVkQ2FudmFzIHNlYW1zIHRvIG9ubHkgY29uc2lkZXIgb25lIGRpbWVuc2lvbiB3aGVuIGNhbGN1bGF0aW5nIHRoZSBtYXhpbXVtIHNpemVcbiAgICAgICAgICAgIC8vIGluIHJlc3BlY3QgdG8gdGhlIGFzcGVjdCByYXRpbyBhbmQgYWx3YXlzIGNvbnNpZGVycyB3aWR0aCBmaXJzdCwgc28gaGVpZ2h0IGlzIGJhc2ljYWxseSBpZ25vcmVkIVxuICAgICAgICAgICAgLy8gVG8gc2V0IGEgbWF4aW11bSBoZWlnaHQsIG5vIHdpZHRoIHBhcmFtZXRlciBzaG91bGQgYmUgc2V0LlxuICAgICAgICAgICAgLy8gRXhhbXBsZSBvZiBjdXJyZW50IHdyb25nIGJlaGF2aW9yOlxuICAgICAgICAgICAgLy8gc291cmNlIG9mIDIwMHgzMDAgd2l0aCByZXNpemUgdG8gMTUweDIwMCByZXN1bHRzIGluIDE1MHgyMjUgPT4gV1JPTkcgKHNob3VsZCBiZTogMTMzeDIwMClcbiAgICAgICAgICAgIC8vIHNvdXJjZSBvZiAyMDB4MzAwIHdpdGggcmVzaXplIHRvIDIwMHgxNTAgcmVzdWx0cyBpbiAyMDB4MzAwID0+IFdST05HIChzaG91bGQgYmU6IDEwMHgxNTApXG4gICAgICAgICAgICAvLyBUaGlzIGlzIGFuIGlzc3VlIHdpdGggY3JvcHBlciwgbm90IHRoaXMgbGlicmFyeVxuICAgICAgICAgICAgcHJldmlld19jYW52YXMgPSB0aGlzLmNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcyh7XG4gICAgICAgICAgICAgICAgd2lkdGg6IHByZXZpZXdfd2lkdGgsXG4gICAgICAgICAgICAgICAgaGVpZ2h0OiBwcmV2aWV3X2hlaWdodFxuICAgICAgICAgICAgfSksXG4gICAgICAgICAgICBpbWFnZV9jYW52YXMgPSB0aGlzLmNyb3BwZXIuZ2V0Q3JvcHBlZENhbnZhcyh7XG4gICAgICAgICAgICAgICAgd2lkdGg6IGltYWdlX3dpZHRoLFxuICAgICAgICAgICAgICAgIGhlaWdodDogaW1hZ2VfaGVpZ2h0XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAvLyBmaWxsIGNhbnZhcyBwcmV2aWV3IGNvbnRhaW5lciB3aXRoIGNyb3BwZWQgaW1hZ2VcbiAgICAgICAgdGhpcy4kY29udGFpbmVyLiRjYW52YXMuaHRtbChwcmV2aWV3X2NhbnZhcyk7XG5cbiAgICAgICAgLy8gZmlsbCBpbnB1dCB3aXRoIGJhc2U2NCBjcm9wcGVkIGltYWdlXG4gICAgICAgIHRoaXMuJGlucHV0LnZhbChpbWFnZV9jYW52YXMudG9EYXRhVVJMKHRoaXMuJGVsLmRhdGEoJ21pbWV0eXBlJyksIHRoaXMuJGVsLmRhdGEoJ3F1YWxpdHknKSkpO1xuXG4gICAgICAgIC8vIGhpZGUgdGhlIG1vZGFsXG4gICAgICAgIHRoaXMuJG1vZGFsLm1vZGFsKCdoaWRlJyk7XG4gICAgfTtcblxuICAgIGlmICh0eXBlb2YgbW9kdWxlICE9PSAndW5kZWZpbmVkJyAmJiAnZXhwb3J0cycgaW4gbW9kdWxlKSB7XG4gICAgICAgIG1vZHVsZS5leHBvcnRzID0gQ3JvcHBlcjtcbiAgICB9IGVsc2Uge1xuICAgICAgICB3aW5kb3cuQ3JvcHBlciA9IENyb3BwZXI7XG4gICAgfVxuXG59KSh3aW5kb3csIGpRdWVyeSk7XG4iLCIvLyBUaGUgbW9kdWxlIGNhY2hlXG52YXIgX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fID0ge307XG5cbi8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG5mdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuXHR2YXIgY2FjaGVkTW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXTtcblx0aWYgKGNhY2hlZE1vZHVsZSAhPT0gdW5kZWZpbmVkKSB7XG5cdFx0cmV0dXJuIGNhY2hlZE1vZHVsZS5leHBvcnRzO1xuXHR9XG5cdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG5cdHZhciBtb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdID0ge1xuXHRcdGlkOiBtb2R1bGVJZCxcblx0XHRsb2FkZWQ6IGZhbHNlLFxuXHRcdGV4cG9ydHM6IHt9XG5cdH07XG5cblx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG5cdF9fd2VicGFja19tb2R1bGVzX19bbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG5cdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcblx0bW9kdWxlLmxvYWRlZCA9IHRydWU7XG5cblx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcblx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xufVxuXG4vLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuX193ZWJwYWNrX3JlcXVpcmVfXy5tID0gX193ZWJwYWNrX21vZHVsZXNfXztcblxuIiwidmFyIGRlZmVycmVkID0gW107XG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8gPSAocmVzdWx0LCBjaHVua0lkcywgZm4sIHByaW9yaXR5KSA9PiB7XG5cdGlmKGNodW5rSWRzKSB7XG5cdFx0cHJpb3JpdHkgPSBwcmlvcml0eSB8fCAwO1xuXHRcdGZvcih2YXIgaSA9IGRlZmVycmVkLmxlbmd0aDsgaSA+IDAgJiYgZGVmZXJyZWRbaSAtIDFdWzJdID4gcHJpb3JpdHk7IGktLSkgZGVmZXJyZWRbaV0gPSBkZWZlcnJlZFtpIC0gMV07XG5cdFx0ZGVmZXJyZWRbaV0gPSBbY2h1bmtJZHMsIGZuLCBwcmlvcml0eV07XG5cdFx0cmV0dXJuO1xuXHR9XG5cdHZhciBub3RGdWxmaWxsZWQgPSBJbmZpbml0eTtcblx0Zm9yICh2YXIgaSA9IDA7IGkgPCBkZWZlcnJlZC5sZW5ndGg7IGkrKykge1xuXHRcdHZhciBbY2h1bmtJZHMsIGZuLCBwcmlvcml0eV0gPSBkZWZlcnJlZFtpXTtcblx0XHR2YXIgZnVsZmlsbGVkID0gdHJ1ZTtcblx0XHRmb3IgKHZhciBqID0gMDsgaiA8IGNodW5rSWRzLmxlbmd0aDsgaisrKSB7XG5cdFx0XHRpZiAoKHByaW9yaXR5ICYgMSA9PT0gMCB8fCBub3RGdWxmaWxsZWQgPj0gcHJpb3JpdHkpICYmIE9iamVjdC5rZXlzKF9fd2VicGFja19yZXF1aXJlX18uTykuZXZlcnkoKGtleSkgPT4gKF9fd2VicGFja19yZXF1aXJlX18uT1trZXldKGNodW5rSWRzW2pdKSkpKSB7XG5cdFx0XHRcdGNodW5rSWRzLnNwbGljZShqLS0sIDEpO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0ZnVsZmlsbGVkID0gZmFsc2U7XG5cdFx0XHRcdGlmKHByaW9yaXR5IDwgbm90RnVsZmlsbGVkKSBub3RGdWxmaWxsZWQgPSBwcmlvcml0eTtcblx0XHRcdH1cblx0XHR9XG5cdFx0aWYoZnVsZmlsbGVkKSB7XG5cdFx0XHRkZWZlcnJlZC5zcGxpY2UoaS0tLCAxKVxuXHRcdFx0cmVzdWx0ID0gZm4oKTtcblx0XHR9XG5cdH1cblx0cmV0dXJuIHJlc3VsdDtcbn07IiwiLy8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbl9fd2VicGFja19yZXF1aXJlX18ubiA9IChtb2R1bGUpID0+IHtcblx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG5cdFx0KCkgPT4gKG1vZHVsZVsnZGVmYXVsdCddKSA6XG5cdFx0KCkgPT4gKG1vZHVsZSk7XG5cdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsIHsgYTogZ2V0dGVyIH0pO1xuXHRyZXR1cm4gZ2V0dGVyO1xufTsiLCIvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9ucyBmb3IgaGFybW9ueSBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSAoZXhwb3J0cywgZGVmaW5pdGlvbikgPT4ge1xuXHRmb3IodmFyIGtleSBpbiBkZWZpbml0aW9uKSB7XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGRlZmluaXRpb24sIGtleSkgJiYgIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBrZXkpKSB7XG5cdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywga2V5LCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZGVmaW5pdGlvbltrZXldIH0pO1xuXHRcdH1cblx0fVxufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLmcgPSAoZnVuY3Rpb24oKSB7XG5cdGlmICh0eXBlb2YgZ2xvYmFsVGhpcyA9PT0gJ29iamVjdCcpIHJldHVybiBnbG9iYWxUaGlzO1xuXHR0cnkge1xuXHRcdHJldHVybiB0aGlzIHx8IG5ldyBGdW5jdGlvbigncmV0dXJuIHRoaXMnKSgpO1xuXHR9IGNhdGNoIChlKSB7XG5cdFx0aWYgKHR5cGVvZiB3aW5kb3cgPT09ICdvYmplY3QnKSByZXR1cm4gd2luZG93O1xuXHR9XG59KSgpOyIsIl9fd2VicGFja19yZXF1aXJlX18ubyA9IChvYmosIHByb3ApID0+IChPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkiLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLm5tZCA9IChtb2R1bGUpID0+IHtcblx0bW9kdWxlLnBhdGhzID0gW107XG5cdGlmICghbW9kdWxlLmNoaWxkcmVuKSBtb2R1bGUuY2hpbGRyZW4gPSBbXTtcblx0cmV0dXJuIG1vZHVsZTtcbn07IiwiLy8gbm8gYmFzZVVSSVxuXG4vLyBvYmplY3QgdG8gc3RvcmUgbG9hZGVkIGFuZCBsb2FkaW5nIGNodW5rc1xuLy8gdW5kZWZpbmVkID0gY2h1bmsgbm90IGxvYWRlZCwgbnVsbCA9IGNodW5rIHByZWxvYWRlZC9wcmVmZXRjaGVkXG4vLyBbcmVzb2x2ZSwgcmVqZWN0LCBQcm9taXNlXSA9IGNodW5rIGxvYWRpbmcsIDAgPSBjaHVuayBsb2FkZWRcbnZhciBpbnN0YWxsZWRDaHVua3MgPSB7XG5cdFwianMvYXBwXCI6IDBcbn07XG5cbi8vIG5vIGNodW5rIG9uIGRlbWFuZCBsb2FkaW5nXG5cbi8vIG5vIHByZWZldGNoaW5nXG5cbi8vIG5vIHByZWxvYWRlZFxuXG4vLyBubyBITVJcblxuLy8gbm8gSE1SIG1hbmlmZXN0XG5cbl9fd2VicGFja19yZXF1aXJlX18uTy5qID0gKGNodW5rSWQpID0+IChpbnN0YWxsZWRDaHVua3NbY2h1bmtJZF0gPT09IDApO1xuXG4vLyBpbnN0YWxsIGEgSlNPTlAgY2FsbGJhY2sgZm9yIGNodW5rIGxvYWRpbmdcbnZhciB3ZWJwYWNrSnNvbnBDYWxsYmFjayA9IChwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbiwgZGF0YSkgPT4ge1xuXHR2YXIgW2NodW5rSWRzLCBtb3JlTW9kdWxlcywgcnVudGltZV0gPSBkYXRhO1xuXHQvLyBhZGQgXCJtb3JlTW9kdWxlc1wiIHRvIHRoZSBtb2R1bGVzIG9iamVjdCxcblx0Ly8gdGhlbiBmbGFnIGFsbCBcImNodW5rSWRzXCIgYXMgbG9hZGVkIGFuZCBmaXJlIGNhbGxiYWNrXG5cdHZhciBtb2R1bGVJZCwgY2h1bmtJZCwgaSA9IDA7XG5cdGZvcihtb2R1bGVJZCBpbiBtb3JlTW9kdWxlcykge1xuXHRcdGlmKF9fd2VicGFja19yZXF1aXJlX18ubyhtb3JlTW9kdWxlcywgbW9kdWxlSWQpKSB7XG5cdFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLm1bbW9kdWxlSWRdID0gbW9yZU1vZHVsZXNbbW9kdWxlSWRdO1xuXHRcdH1cblx0fVxuXHRpZihydW50aW1lKSB2YXIgcmVzdWx0ID0gcnVudGltZShfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblx0aWYocGFyZW50Q2h1bmtMb2FkaW5nRnVuY3Rpb24pIHBhcmVudENodW5rTG9hZGluZ0Z1bmN0aW9uKGRhdGEpO1xuXHRmb3IoO2kgPCBjaHVua0lkcy5sZW5ndGg7IGkrKykge1xuXHRcdGNodW5rSWQgPSBjaHVua0lkc1tpXTtcblx0XHRpZihfX3dlYnBhY2tfcmVxdWlyZV9fLm8oaW5zdGFsbGVkQ2h1bmtzLCBjaHVua0lkKSAmJiBpbnN0YWxsZWRDaHVua3NbY2h1bmtJZF0pIHtcblx0XHRcdGluc3RhbGxlZENodW5rc1tjaHVua0lkXVswXSgpO1xuXHRcdH1cblx0XHRpbnN0YWxsZWRDaHVua3NbY2h1bmtJZHNbaV1dID0gMDtcblx0fVxuXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXy5PKHJlc3VsdCk7XG59XG5cbnZhciBjaHVua0xvYWRpbmdHbG9iYWwgPSBzZWxmW1wid2VicGFja0NodW5rXCJdID0gc2VsZltcIndlYnBhY2tDaHVua1wiXSB8fCBbXTtcbmNodW5rTG9hZGluZ0dsb2JhbC5mb3JFYWNoKHdlYnBhY2tKc29ucENhbGxiYWNrLmJpbmQobnVsbCwgMCkpO1xuY2h1bmtMb2FkaW5nR2xvYmFsLnB1c2ggPSB3ZWJwYWNrSnNvbnBDYWxsYmFjay5iaW5kKG51bGwsIGNodW5rTG9hZGluZ0dsb2JhbC5wdXNoLmJpbmQoY2h1bmtMb2FkaW5nR2xvYmFsKSk7IiwiLy8gc3RhcnR1cFxuLy8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4vLyBUaGlzIGVudHJ5IG1vZHVsZSBkZXBlbmRzIG9uIG90aGVyIGxvYWRlZCBjaHVua3MgYW5kIGV4ZWN1dGlvbiBuZWVkIHRvIGJlIGRlbGF5ZWRcbnZhciBfX3dlYnBhY2tfZXhwb3J0c19fID0gX193ZWJwYWNrX3JlcXVpcmVfXy5PKHVuZGVmaW5lZCwgW1widmVuZG9ycy1ub2RlX21vZHVsZXNfYm9vdHN0cmFwX2Rpc3RfanNfYm9vdHN0cmFwX2pzLW5vZGVfbW9kdWxlc19jb3JlLWpzX21vZHVsZXNfZXNfYXJyYXlfZmluLWMxMTViM1wiXSwgKCkgPT4gKF9fd2VicGFja19yZXF1aXJlX18oXCIuL2Fzc2V0cy9qcy9hcHAuanNcIikpKVxuX193ZWJwYWNrX2V4cG9ydHNfXyA9IF9fd2VicGFja19yZXF1aXJlX18uTyhfX3dlYnBhY2tfZXhwb3J0c19fKTtcbiJdLCJzb3VyY2VSb290IjoiIn0=