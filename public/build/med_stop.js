(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["med_stop"],{

/***/ "./assets/js/medicat_stop.js":
/*!***********************************!*\
  !*** ./assets/js/medicat_stop.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.find */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);


var Medicat = {
  initialize: function initialize($wrapper) {
    this.$wrapper = $wrapper;
    this.$wrapper.find('.js-stop-medicat').on('click', this.handleStop);
  },
  handleStop: function handleStop(e) {
    e.preventDefault();
    jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).addClass('text-danger');
    var $row = jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).closest('tr');
    var stopUrl = jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).data('url');
    jquery__WEBPACK_IMPORTED_MODULE_1___default.a.ajax({
      url: stopUrl,
      method: 'POST',
      success: function success() {
        $row.fadeOut();
      }
    });
  }
};
jquery__WEBPACK_IMPORTED_MODULE_1___default()(document).ready(function () {
  var $table = jquery__WEBPACK_IMPORTED_MODULE_1___default()('.js-medicats-table');
  Medicat.initialize($table);
});

/***/ }),

/***/ "./node_modules/core-js/internals/array-method-uses-to-length.js":
/*!***********************************************************************!*\
  !*** ./node_modules/core-js/internals/array-method-uses-to-length.js ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var has = __webpack_require__(/*! ../internals/has */ "./node_modules/core-js/internals/has.js");

var defineProperty = Object.defineProperty;
var cache = {};

var thrower = function (it) { throw it; };

module.exports = function (METHOD_NAME, options) {
  if (has(cache, METHOD_NAME)) return cache[METHOD_NAME];
  if (!options) options = {};
  var method = [][METHOD_NAME];
  var ACCESSORS = has(options, 'ACCESSORS') ? options.ACCESSORS : false;
  var argument0 = has(options, 0) ? options[0] : thrower;
  var argument1 = has(options, 1) ? options[1] : undefined;

  return cache[METHOD_NAME] = !!method && !fails(function () {
    if (ACCESSORS && !DESCRIPTORS) return true;
    var O = { length: -1 };

    if (ACCESSORS) defineProperty(O, 1, { enumerable: true, get: thrower });
    else O[1] = 1;

    method.call(O, argument0, argument1);
  });
};


/***/ }),

/***/ "./node_modules/core-js/modules/es.array.find.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/modules/es.array.find.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var $find = __webpack_require__(/*! ../internals/array-iteration */ "./node_modules/core-js/internals/array-iteration.js").find;
var addToUnscopables = __webpack_require__(/*! ../internals/add-to-unscopables */ "./node_modules/core-js/internals/add-to-unscopables.js");
var arrayMethodUsesToLength = __webpack_require__(/*! ../internals/array-method-uses-to-length */ "./node_modules/core-js/internals/array-method-uses-to-length.js");

var FIND = 'find';
var SKIPS_HOLES = true;

var USES_TO_LENGTH = arrayMethodUsesToLength(FIND);

// Shouldn't skip holes
if (FIND in []) Array(1)[FIND](function () { SKIPS_HOLES = false; });

// `Array.prototype.find` method
// https://tc39.github.io/ecma262/#sec-array.prototype.find
$({ target: 'Array', proto: true, forced: SKIPS_HOLES || !USES_TO_LENGTH }, {
  find: function find(callbackfn /* , that = undefined */) {
    return $find(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
  }
});

// https://tc39.github.io/ecma262/#sec-array.prototype-@@unscopables
addToUnscopables(FIND);


/***/ })

},[["./assets/js/medicat_stop.js","runtime","vendors~app~delete~dp_en~dp_es~dp_fr~dp_nl~med_stop~search_p~sel_treat","vendors~app~med_stop~search_p"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvbWVkaWNhdF9zdG9wLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9hcnJheS1tZXRob2QtdXNlcy10by1sZW5ndGguanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5hcnJheS5maW5kLmpzIl0sIm5hbWVzIjpbIk1lZGljYXQiLCJpbml0aWFsaXplIiwiJHdyYXBwZXIiLCJmaW5kIiwib24iLCJoYW5kbGVTdG9wIiwiZSIsInByZXZlbnREZWZhdWx0IiwiJCIsImFkZENsYXNzIiwiJHJvdyIsImNsb3Nlc3QiLCJzdG9wVXJsIiwiZGF0YSIsImFqYXgiLCJ1cmwiLCJtZXRob2QiLCJzdWNjZXNzIiwiZmFkZU91dCIsImRvY3VtZW50IiwicmVhZHkiLCIkdGFibGUiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7QUFBQTtBQUVBLElBQUlBLE9BQU8sR0FBRztBQUVWQyxZQUFVLEVBQUUsb0JBQVNDLFFBQVQsRUFBbUI7QUFDM0IsU0FBS0EsUUFBTCxHQUFnQkEsUUFBaEI7QUFDQSxTQUFLQSxRQUFMLENBQWNDLElBQWQsQ0FBbUIsa0JBQW5CLEVBQXVDQyxFQUF2QyxDQUNJLE9BREosRUFFSSxLQUFLQyxVQUZUO0FBSUgsR0FSUztBQVVWQSxZQUFVLEVBQUUsb0JBQVNDLENBQVQsRUFBWTtBQUNwQkEsS0FBQyxDQUFDQyxjQUFGO0FBRUFDLGlEQUFDLENBQUMsSUFBRCxDQUFELENBQVFDLFFBQVIsQ0FBaUIsYUFBakI7QUFFQSxRQUFJQyxJQUFJLEdBQUdGLDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVFHLE9BQVIsQ0FBZ0IsSUFBaEIsQ0FBWDtBQUNBLFFBQUlDLE9BQU8sR0FBR0osNkNBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUUssSUFBUixDQUFhLEtBQWIsQ0FBZDtBQUNBTCxpREFBQyxDQUFDTSxJQUFGLENBQU87QUFDSEMsU0FBRyxFQUFFSCxPQURGO0FBRUhJLFlBQU0sRUFBRSxNQUZMO0FBR0hDLGFBQU8sRUFBRSxtQkFBVztBQUNoQlAsWUFBSSxDQUFDUSxPQUFMO0FBQ0g7QUFMRSxLQUFQO0FBT0g7QUF4QlMsQ0FBZDtBQTRCQVYsNkNBQUMsQ0FBQ1csUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBVztBQUV6QixNQUFJQyxNQUFNLEdBQUdiLDZDQUFDLENBQUMsb0JBQUQsQ0FBZDtBQUNBUixTQUFPLENBQUNDLFVBQVIsQ0FBbUJvQixNQUFuQjtBQUNILENBSkQsRTs7Ozs7Ozs7Ozs7QUM5QkEsa0JBQWtCLG1CQUFPLENBQUMsaUZBQTBCO0FBQ3BELFlBQVksbUJBQU8sQ0FBQyxxRUFBb0I7QUFDeEMsVUFBVSxtQkFBTyxDQUFDLGlFQUFrQjs7QUFFcEM7QUFDQTs7QUFFQSw2QkFBNkIsVUFBVTs7QUFFdkM7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLGFBQWE7O0FBRWIseUNBQXlDLGlDQUFpQztBQUMxRTs7QUFFQTtBQUNBLEdBQUc7QUFDSDs7Ozs7Ozs7Ozs7OztBQzFCYTtBQUNiLFFBQVEsbUJBQU8sQ0FBQyx1RUFBcUI7QUFDckMsWUFBWSxtQkFBTyxDQUFDLHlGQUE4QjtBQUNsRCx1QkFBdUIsbUJBQU8sQ0FBQywrRkFBaUM7QUFDaEUsOEJBQThCLG1CQUFPLENBQUMsaUhBQTBDOztBQUVoRjtBQUNBOztBQUVBOztBQUVBO0FBQ0EsNENBQTRDLHFCQUFxQixFQUFFOztBQUVuRTtBQUNBO0FBQ0EsR0FBRyx1RUFBdUU7QUFDMUU7QUFDQTtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBIiwiZmlsZSI6Im1lZF9zdG9wLmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcblxudmFyIE1lZGljYXQgPSB7XG5cbiAgICBpbml0aWFsaXplOiBmdW5jdGlvbigkd3JhcHBlcikge1xuICAgICAgICB0aGlzLiR3cmFwcGVyID0gJHdyYXBwZXI7XG4gICAgICAgIHRoaXMuJHdyYXBwZXIuZmluZCgnLmpzLXN0b3AtbWVkaWNhdCcpLm9uKFxuICAgICAgICAgICAgJ2NsaWNrJyxcbiAgICAgICAgICAgIHRoaXMuaGFuZGxlU3RvcFxuICAgICAgICApO1xuICAgIH0sXG5cbiAgICBoYW5kbGVTdG9wOiBmdW5jdGlvbihlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICAkKHRoaXMpLmFkZENsYXNzKCd0ZXh0LWRhbmdlcicpO1xuXG4gICAgICAgIHZhciAkcm93ID0gJCh0aGlzKS5jbG9zZXN0KCd0cicpO1xuICAgICAgICB2YXIgc3RvcFVybCA9ICQodGhpcykuZGF0YSgndXJsJyk7XG4gICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICB1cmw6IHN0b3BVcmwsXG4gICAgICAgICAgICBtZXRob2Q6ICdQT1NUJyxcbiAgICAgICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICRyb3cuZmFkZU91dCgpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcbiAgICB9LFxuXG59O1xuXG4kKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBcbiAgICB2YXIgJHRhYmxlID0gJCgnLmpzLW1lZGljYXRzLXRhYmxlJyk7XG4gICAgTWVkaWNhdC5pbml0aWFsaXplKCR0YWJsZSk7XG59KTsgICBcblxuIiwidmFyIERFU0NSSVBUT1JTID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2Rlc2NyaXB0b3JzJyk7XG52YXIgZmFpbHMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZmFpbHMnKTtcbnZhciBoYXMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvaGFzJyk7XG5cbnZhciBkZWZpbmVQcm9wZXJ0eSA9IE9iamVjdC5kZWZpbmVQcm9wZXJ0eTtcbnZhciBjYWNoZSA9IHt9O1xuXG52YXIgdGhyb3dlciA9IGZ1bmN0aW9uIChpdCkgeyB0aHJvdyBpdDsgfTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiAoTUVUSE9EX05BTUUsIG9wdGlvbnMpIHtcbiAgaWYgKGhhcyhjYWNoZSwgTUVUSE9EX05BTUUpKSByZXR1cm4gY2FjaGVbTUVUSE9EX05BTUVdO1xuICBpZiAoIW9wdGlvbnMpIG9wdGlvbnMgPSB7fTtcbiAgdmFyIG1ldGhvZCA9IFtdW01FVEhPRF9OQU1FXTtcbiAgdmFyIEFDQ0VTU09SUyA9IGhhcyhvcHRpb25zLCAnQUNDRVNTT1JTJykgPyBvcHRpb25zLkFDQ0VTU09SUyA6IGZhbHNlO1xuICB2YXIgYXJndW1lbnQwID0gaGFzKG9wdGlvbnMsIDApID8gb3B0aW9uc1swXSA6IHRocm93ZXI7XG4gIHZhciBhcmd1bWVudDEgPSBoYXMob3B0aW9ucywgMSkgPyBvcHRpb25zWzFdIDogdW5kZWZpbmVkO1xuXG4gIHJldHVybiBjYWNoZVtNRVRIT0RfTkFNRV0gPSAhIW1ldGhvZCAmJiAhZmFpbHMoZnVuY3Rpb24gKCkge1xuICAgIGlmIChBQ0NFU1NPUlMgJiYgIURFU0NSSVBUT1JTKSByZXR1cm4gdHJ1ZTtcbiAgICB2YXIgTyA9IHsgbGVuZ3RoOiAtMSB9O1xuXG4gICAgaWYgKEFDQ0VTU09SUykgZGVmaW5lUHJvcGVydHkoTywgMSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IHRocm93ZXIgfSk7XG4gICAgZWxzZSBPWzFdID0gMTtcblxuICAgIG1ldGhvZC5jYWxsKE8sIGFyZ3VtZW50MCwgYXJndW1lbnQxKTtcbiAgfSk7XG59O1xuIiwiJ3VzZSBzdHJpY3QnO1xudmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG52YXIgJGZpbmQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvYXJyYXktaXRlcmF0aW9uJykuZmluZDtcbnZhciBhZGRUb1Vuc2NvcGFibGVzID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2FkZC10by11bnNjb3BhYmxlcycpO1xudmFyIGFycmF5TWV0aG9kVXNlc1RvTGVuZ3RoID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2FycmF5LW1ldGhvZC11c2VzLXRvLWxlbmd0aCcpO1xuXG52YXIgRklORCA9ICdmaW5kJztcbnZhciBTS0lQU19IT0xFUyA9IHRydWU7XG5cbnZhciBVU0VTX1RPX0xFTkdUSCA9IGFycmF5TWV0aG9kVXNlc1RvTGVuZ3RoKEZJTkQpO1xuXG4vLyBTaG91bGRuJ3Qgc2tpcCBob2xlc1xuaWYgKEZJTkQgaW4gW10pIEFycmF5KDEpW0ZJTkRdKGZ1bmN0aW9uICgpIHsgU0tJUFNfSE9MRVMgPSBmYWxzZTsgfSk7XG5cbi8vIGBBcnJheS5wcm90b3R5cGUuZmluZGAgbWV0aG9kXG4vLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy1hcnJheS5wcm90b3R5cGUuZmluZFxuJCh7IHRhcmdldDogJ0FycmF5JywgcHJvdG86IHRydWUsIGZvcmNlZDogU0tJUFNfSE9MRVMgfHwgIVVTRVNfVE9fTEVOR1RIIH0sIHtcbiAgZmluZDogZnVuY3Rpb24gZmluZChjYWxsYmFja2ZuIC8qICwgdGhhdCA9IHVuZGVmaW5lZCAqLykge1xuICAgIHJldHVybiAkZmluZCh0aGlzLCBjYWxsYmFja2ZuLCBhcmd1bWVudHMubGVuZ3RoID4gMSA/IGFyZ3VtZW50c1sxXSA6IHVuZGVmaW5lZCk7XG4gIH1cbn0pO1xuXG4vLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy1hcnJheS5wcm90b3R5cGUtQEB1bnNjb3BhYmxlc1xuYWRkVG9VbnNjb3BhYmxlcyhGSU5EKTtcbiJdLCJzb3VyY2VSb290IjoiIn0=