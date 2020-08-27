(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["sel_treat"],{

/***/ "./assets/js/selectTreatment2.js":
/*!***************************************!*\
  !*** ./assets/js/selectTreatment2.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.function.name */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);


jquery__WEBPACK_IMPORTED_MODULE_1___default()(document).ready(function () {
  // Selección del 1er dr. dixponible y día actual para el tratamiento
  var selector = document.getElementById('js-select-medics');
  var value = selector[selector.selectedIndex].text;
  document.getElementById("js-selected-doctor").innerHTML = value;
  document.getElementById("js-selected-treatment").innerHTML = '';
  document.getElementById("js-selected-place").innerHTML = '';
  var inputValue = document.getElementById("js-datepicker").value;
  document.getElementById("js-selected-date").innerHTML = inputValue; // Recuperación de los tratamientos de un tipo

  jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-types").change(function () {
    var typeid = jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).val();
    var autocompleteUrl = jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-types").data('url');
    autocompleteUrl = autocompleteUrl + '?query=' + typeid; //alert(autocompleteUrl);

    jquery__WEBPACK_IMPORTED_MODULE_1___default.a.ajax({
      url: autocompleteUrl,
      type: 'post',
      dataType: 'json',
      success: function success(response) {
        var len = response.length;
        jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-treatments").empty();

        for (var i = 0; i < len; i++) {
          var id = response[i]['id'];
          var name = response[i]['name'];
          jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-treatments").append('<option value="' + id + '">' + name + '</option>');
        }

        var selector = document.getElementById('js-select-treatments');
        var value = selector[selector.selectedIndex].text;
        document.getElementById("js-selected-treatment").innerHTML = value;
      }
    });
  });
  jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-treatments").change(function () {
    var selector = document.getElementById('js-select-treatments');
    var value = selector[selector.selectedIndex].text;
    document.getElementById("js-selected-treatment").innerHTML = value;

    if (document.getElementById("js-selected-treatment").innerHTML.length && document.getElementById("js-selected-place").innerHTML.length) {
      jquery__WEBPACK_IMPORTED_MODULE_1___default()("#collapseNewTrat").collapse({
        'show': true
      });
    }
  });
  jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-medics").change(function () {
    var selector = document.getElementById('js-select-medics');
    var value = selector[selector.selectedIndex].text;
    document.getElementById("js-selected-doctor").innerHTML = value;
  });
  jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-select-places").change(function () {
    var selector = document.getElementById('js-select-places');
    var value = selector[selector.selectedIndex].text;
    document.getElementById("js-selected-place").innerHTML = value;

    if (document.getElementById("js-selected-treatment").innerHTML.length && document.getElementById("js-selected-place").innerHTML.length) {
      jquery__WEBPACK_IMPORTED_MODULE_1___default()("#collapseNewTrat").collapse({
        'show': true
      });
    }
  });
  jquery__WEBPACK_IMPORTED_MODULE_1___default()("#js-datepicker").change(function () {
    var inputValue = document.getElementById("js-datepicker").value;
    document.getElementById("js-selected-date").innerHTML = inputValue;
  });
});

/***/ }),

/***/ "./node_modules/core-js/internals/an-object.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/an-object.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

module.exports = function (it) {
  if (!isObject(it)) {
    throw TypeError(String(it) + ' is not an object');
  } return it;
};


/***/ }),

/***/ "./node_modules/core-js/internals/descriptors.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/descriptors.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");

// Thank's IE8 for his funny defineProperty
module.exports = !fails(function () {
  return Object.defineProperty({}, 1, { get: function () { return 7; } })[1] != 7;
});


/***/ }),

/***/ "./node_modules/core-js/internals/document-create-element.js":
/*!*******************************************************************!*\
  !*** ./node_modules/core-js/internals/document-create-element.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

var document = global.document;
// typeof document.createElement is 'object' in old IE
var EXISTS = isObject(document) && isObject(document.createElement);

module.exports = function (it) {
  return EXISTS ? document.createElement(it) : {};
};


/***/ }),

/***/ "./node_modules/core-js/internals/fails.js":
/*!*************************************************!*\
  !*** ./node_modules/core-js/internals/fails.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (error) {
    return true;
  }
};


/***/ }),

/***/ "./node_modules/core-js/internals/global.js":
/*!**************************************************!*\
  !*** ./node_modules/core-js/internals/global.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var check = function (it) {
  return it && it.Math == Math && it;
};

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
module.exports =
  // eslint-disable-next-line no-undef
  check(typeof globalThis == 'object' && globalThis) ||
  check(typeof window == 'object' && window) ||
  check(typeof self == 'object' && self) ||
  check(typeof global == 'object' && global) ||
  // eslint-disable-next-line no-new-func
  Function('return this')();

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/core-js/internals/ie8-dom-define.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/ie8-dom-define.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var createElement = __webpack_require__(/*! ../internals/document-create-element */ "./node_modules/core-js/internals/document-create-element.js");

// Thank's IE8 for his funny defineProperty
module.exports = !DESCRIPTORS && !fails(function () {
  return Object.defineProperty(createElement('div'), 'a', {
    get: function () { return 7; }
  }).a != 7;
});


/***/ }),

/***/ "./node_modules/core-js/internals/is-object.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/is-object.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "./node_modules/core-js/internals/object-define-property.js":
/*!******************************************************************!*\
  !*** ./node_modules/core-js/internals/object-define-property.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var IE8_DOM_DEFINE = __webpack_require__(/*! ../internals/ie8-dom-define */ "./node_modules/core-js/internals/ie8-dom-define.js");
var anObject = __webpack_require__(/*! ../internals/an-object */ "./node_modules/core-js/internals/an-object.js");
var toPrimitive = __webpack_require__(/*! ../internals/to-primitive */ "./node_modules/core-js/internals/to-primitive.js");

var nativeDefineProperty = Object.defineProperty;

// `Object.defineProperty` method
// https://tc39.github.io/ecma262/#sec-object.defineproperty
exports.f = DESCRIPTORS ? nativeDefineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return nativeDefineProperty(O, P, Attributes);
  } catch (error) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-primitive.js":
/*!********************************************************!*\
  !*** ./node_modules/core-js/internals/to-primitive.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ../internals/is-object */ "./node_modules/core-js/internals/is-object.js");

// `ToPrimitive` abstract operation
// https://tc39.github.io/ecma262/#sec-toprimitive
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (input, PREFERRED_STRING) {
  if (!isObject(input)) return input;
  var fn, val;
  if (PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  if (typeof (fn = input.valueOf) == 'function' && !isObject(val = fn.call(input))) return val;
  if (!PREFERRED_STRING && typeof (fn = input.toString) == 'function' && !isObject(val = fn.call(input))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "./node_modules/core-js/modules/es.function.name.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/modules/es.function.name.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var DESCRIPTORS = __webpack_require__(/*! ../internals/descriptors */ "./node_modules/core-js/internals/descriptors.js");
var defineProperty = __webpack_require__(/*! ../internals/object-define-property */ "./node_modules/core-js/internals/object-define-property.js").f;

var FunctionPrototype = Function.prototype;
var FunctionPrototypeToString = FunctionPrototype.toString;
var nameRE = /^\s*function ([^ (]*)/;
var NAME = 'name';

// Function instances `.name` property
// https://tc39.github.io/ecma262/#sec-function-instances-name
if (DESCRIPTORS && !(NAME in FunctionPrototype)) {
  defineProperty(FunctionPrototype, NAME, {
    configurable: true,
    get: function () {
      try {
        return FunctionPrototypeToString.call(this).match(nameRE)[1];
      } catch (error) {
        return '';
      }
    }
  });
}


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ })

},[["./assets/js/selectTreatment2.js","runtime","vendors~app~delete~dp_en~dp_es~dp_fr~dp_nl~med_stop~search_p~sel_treat"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvc2VsZWN0VHJlYXRtZW50Mi5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvYW4tb2JqZWN0LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9kZXNjcmlwdG9ycy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvZG9jdW1lbnQtY3JlYXRlLWVsZW1lbnQuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvaW50ZXJuYWxzL2ZhaWxzLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9nbG9iYWwuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvaW50ZXJuYWxzL2llOC1kb20tZGVmaW5lLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9pcy1vYmplY3QuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvaW50ZXJuYWxzL29iamVjdC1kZWZpbmUtcHJvcGVydHkuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvaW50ZXJuYWxzL3RvLXByaW1pdGl2ZS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLmZ1bmN0aW9uLm5hbWUuanMiLCJ3ZWJwYWNrOi8vLyh3ZWJwYWNrKS9idWlsZGluL2dsb2JhbC5qcyJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsInNlbGVjdG9yIiwiZ2V0RWxlbWVudEJ5SWQiLCJ2YWx1ZSIsInNlbGVjdGVkSW5kZXgiLCJ0ZXh0IiwiaW5uZXJIVE1MIiwiaW5wdXRWYWx1ZSIsImNoYW5nZSIsInR5cGVpZCIsInZhbCIsImF1dG9jb21wbGV0ZVVybCIsImRhdGEiLCJhamF4IiwidXJsIiwidHlwZSIsImRhdGFUeXBlIiwic3VjY2VzcyIsInJlc3BvbnNlIiwibGVuIiwibGVuZ3RoIiwiZW1wdHkiLCJpIiwiaWQiLCJuYW1lIiwiYXBwZW5kIiwiY29sbGFwc2UiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7QUFBQTtBQUVBQSw2Q0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsS0FBWixDQUFrQixZQUFVO0FBRXhCO0FBRUEsTUFBSUMsUUFBUSxHQUFHRixRQUFRLENBQUNHLGNBQVQsQ0FBd0Isa0JBQXhCLENBQWY7QUFDQSxNQUFJQyxLQUFLLEdBQUdGLFFBQVEsQ0FBQ0EsUUFBUSxDQUFDRyxhQUFWLENBQVIsQ0FBaUNDLElBQTdDO0FBQ0FOLFVBQVEsQ0FBQ0csY0FBVCxDQUF3QixvQkFBeEIsRUFBOENJLFNBQTlDLEdBQTBESCxLQUExRDtBQUVBSixVQUFRLENBQUNHLGNBQVQsQ0FBd0IsdUJBQXhCLEVBQWlESSxTQUFqRCxHQUE2RCxFQUE3RDtBQUNBUCxVQUFRLENBQUNHLGNBQVQsQ0FBd0IsbUJBQXhCLEVBQTZDSSxTQUE3QyxHQUF5RCxFQUF6RDtBQUVBLE1BQUlDLFVBQVUsR0FBR1IsUUFBUSxDQUFDRyxjQUFULENBQXdCLGVBQXhCLEVBQXlDQyxLQUExRDtBQUNBSixVQUFRLENBQUNHLGNBQVQsQ0FBd0Isa0JBQXhCLEVBQTRDSSxTQUE1QyxHQUF3REMsVUFBeEQsQ0Fad0IsQ0FleEI7O0FBRUFULCtDQUFDLENBQUMsa0JBQUQsQ0FBRCxDQUFzQlUsTUFBdEIsQ0FBNkIsWUFBVTtBQUNuQyxRQUFJQyxNQUFNLEdBQUdYLDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVFZLEdBQVIsRUFBYjtBQUNBLFFBQUlDLGVBQWUsR0FBR2IsNkNBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCYyxJQUF0QixDQUEyQixLQUEzQixDQUF0QjtBQUNBRCxtQkFBZSxHQUFHQSxlQUFlLEdBQUMsU0FBaEIsR0FBMEJGLE1BQTVDLENBSG1DLENBS25DOztBQUVBWCxpREFB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QUNwRCxxQkFBcUIsbUJBQU8sQ0FBQyx1RkFBNkI7QUFDMUQsZUFBZSxtQkFBTyxDQUFDLDZFQUF3QjtBQUMvQyxrQkFBa0IsbUJBQU8sQ0FBQyxtRkFBMkI7O0FBRXJEOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHLGdCQUFnQjtBQUNuQjtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDbkJBLGVBQWUsbUJBQU8sQ0FBQyw2RUFBd0I7O0FBRS9DO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDYkEsa0JBQWtCLG1CQUFPLENBQUMsaUZBQTBCO0FBQ3BELHFCQUFxQixtQkFBTyxDQUFDLHVHQUFxQzs7QUFFbEU7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0g7Ozs7Ozs7Ozs7OztBQ3JCQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBLENBQUM7QUFDRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLDRDQUE0Qzs7QUFFNUMiLCJmaWxlIjoic2VsX3RyZWF0LmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKXtcblxuICAgIC8vIFNlbGVjY2nDs24gZGVsIDFlciBkci4gZGl4cG9uaWJsZSB5IGTDrWEgYWN0dWFsIHBhcmEgZWwgdHJhdGFtaWVudG9cblxuICAgIHZhciBzZWxlY3RvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdqcy1zZWxlY3QtbWVkaWNzJyk7XG4gICAgdmFyIHZhbHVlID0gc2VsZWN0b3Jbc2VsZWN0b3Iuc2VsZWN0ZWRJbmRleF0udGV4dDtcbiAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImpzLXNlbGVjdGVkLWRvY3RvclwiKS5pbm5lckhUTUwgPSB2YWx1ZTtcblxuICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtdHJlYXRtZW50XCIpLmlubmVySFRNTCA9ICcnO1xuICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtcGxhY2VcIikuaW5uZXJIVE1MID0gJyc7XG5cbiAgICBsZXQgaW5wdXRWYWx1ZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtZGF0ZXBpY2tlclwiKS52YWx1ZTtcbiAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImpzLXNlbGVjdGVkLWRhdGVcIikuaW5uZXJIVE1MID0gaW5wdXRWYWx1ZTtcblxuXG4gICAgLy8gUmVjdXBlcmFjacOzbiBkZSBsb3MgdHJhdGFtaWVudG9zIGRlIHVuIHRpcG9cblxuICAgICQoXCIjanMtc2VsZWN0LXR5cGVzXCIpLmNoYW5nZShmdW5jdGlvbigpe1xuICAgICAgICB2YXIgdHlwZWlkID0gJCh0aGlzKS52YWwoKTtcbiAgICAgICAgdmFyIGF1dG9jb21wbGV0ZVVybCA9ICQoXCIjanMtc2VsZWN0LXR5cGVzXCIpLmRhdGEoJ3VybCcpO1xuICAgICAgICBhdXRvY29tcGxldGVVcmwgPSBhdXRvY29tcGxldGVVcmwrJz9xdWVyeT0nK3R5cGVpZDtcbiAgICBcbiAgICAgICAgLy9hbGVydChhdXRvY29tcGxldGVVcmwpO1xuICAgIFxuICAgICAgICAkLmFqYXgoe1xuICAgICAgICAgICAgdXJsOiBhdXRvY29tcGxldGVVcmwsXG4gICAgICAgICAgICB0eXBlOiAncG9zdCcsXG4gICAgICAgICAgICBkYXRhVHlwZTogJ2pzb24nLFxuICAgICAgICAgICAgc3VjY2VzczpmdW5jdGlvbihyZXNwb25zZSl7XG4gICAgXG4gICAgICAgICAgICAgICAgdmFyIGxlbiA9IHJlc3BvbnNlLmxlbmd0aDtcbiAgICBcbiAgICAgICAgICAgICAgICAkKFwiI2pzLXNlbGVjdC10cmVhdG1lbnRzXCIpLmVtcHR5KCk7XG5cbiAgICAgICAgICAgICAgICBmb3IoIHZhciBpID0gMDsgaTxsZW47IGkrKyl7XG4gICAgICAgICAgICAgICAgICAgIHZhciBpZCA9IHJlc3BvbnNlW2ldWydpZCddO1xuICAgICAgICAgICAgICAgICAgICB2YXIgbmFtZSA9IHJlc3BvbnNlW2ldWyduYW1lJ107XG4gICAgICAgICAgICBcbiAgICAgICAgICAgICAgICAgICAgXG4gICAgICAgICAgICAgICAgICAgICQoXCIjanMtc2VsZWN0LXRyZWF0bWVudHNcIikuYXBwZW5kKCc8b3B0aW9uIHZhbHVlPVwiJytpZCsnXCI+JytuYW1lKyc8L29wdGlvbj4nKTsgICAgICAgICAgICBcbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICB2YXIgc2VsZWN0b3IgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnanMtc2VsZWN0LXRyZWF0bWVudHMnKTtcbiAgICAgICAgICAgICAgICB2YXIgdmFsdWUgPSBzZWxlY3RvcltzZWxlY3Rvci5zZWxlY3RlZEluZGV4XS50ZXh0O1xuICAgICAgICAgICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtdHJlYXRtZW50XCIpLmlubmVySFRNTCA9IHZhbHVlO1xuXG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgJChcIiNqcy1zZWxlY3QtdHJlYXRtZW50c1wiKS5jaGFuZ2UoZnVuY3Rpb24oKXtcbiAgICAgICAgdmFyIHNlbGVjdG9yID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2pzLXNlbGVjdC10cmVhdG1lbnRzJyk7XG4gICAgICAgIHZhciB2YWx1ZSA9IHNlbGVjdG9yW3NlbGVjdG9yLnNlbGVjdGVkSW5kZXhdLnRleHQ7XG4gICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtdHJlYXRtZW50XCIpLmlubmVySFRNTCA9IHZhbHVlO1xuXG4gICAgICAgIGlmKChkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImpzLXNlbGVjdGVkLXRyZWF0bWVudFwiKS5pbm5lckhUTUwpLmxlbmd0aFxuICAgICAgICAgICAgJiYgKGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtcGxhY2VcIikuaW5uZXJIVE1MKS5sZW5ndGgpXG4gICAgICAgIHtcbiAgICAgICAgICAgICQoXCIjY29sbGFwc2VOZXdUcmF0XCIpLmNvbGxhcHNlKHsnc2hvdyc6dHJ1ZX0pO1xuICAgICAgICB9XG5cbiAgICB9KTtcblxuICAgICQoXCIjanMtc2VsZWN0LW1lZGljc1wiKS5jaGFuZ2UoZnVuY3Rpb24oKXtcbiAgICAgICAgdmFyIHNlbGVjdG9yID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2pzLXNlbGVjdC1tZWRpY3MnKTtcbiAgICAgICAgdmFyIHZhbHVlID0gc2VsZWN0b3Jbc2VsZWN0b3Iuc2VsZWN0ZWRJbmRleF0udGV4dDtcbiAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJqcy1zZWxlY3RlZC1kb2N0b3JcIikuaW5uZXJIVE1MID0gdmFsdWU7XG4gICAgfSk7XG5cbiAgICAkKFwiI2pzLXNlbGVjdC1wbGFjZXNcIikuY2hhbmdlKGZ1bmN0aW9uKCl7XG4gICAgICAgIHZhciBzZWxlY3RvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdqcy1zZWxlY3QtcGxhY2VzJyk7XG4gICAgICAgIHZhciB2YWx1ZSA9IHNlbGVjdG9yW3NlbGVjdG9yLnNlbGVjdGVkSW5kZXhdLnRleHQ7XG4gICAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtcGxhY2VcIikuaW5uZXJIVE1MID0gdmFsdWU7XG5cbiAgICAgICAgaWYoKGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwianMtc2VsZWN0ZWQtdHJlYXRtZW50XCIpLmlubmVySFRNTCkubGVuZ3RoXG4gICAgICAgICAgICAmJiAoZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJqcy1zZWxlY3RlZC1wbGFjZVwiKS5pbm5lckhUTUwpLmxlbmd0aClcbiAgICAgICAge1xuICAgICAgICAgICAgJChcIiNjb2xsYXBzZU5ld1RyYXRcIikuY29sbGFwc2UoeydzaG93Jzp0cnVlfSk7XG4gICAgICAgIH1cbiAgICAgICAgXG4gICAgfSk7XG5cbiAgICAkKFwiI2pzLWRhdGVwaWNrZXJcIikuY2hhbmdlKGZ1bmN0aW9uKCl7XG4gICAgICAgIGxldCBpbnB1dFZhbHVlID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJqcy1kYXRlcGlja2VyXCIpLnZhbHVlO1xuICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcImpzLXNlbGVjdGVkLWRhdGVcIikuaW5uZXJIVE1MID0gaW5wdXRWYWx1ZTtcbiAgICB9KTtcblxuICAgIFxufSk7XG4gICAgXG4gICAgIiwidmFyIGlzT2JqZWN0ID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2lzLW9iamVjdCcpO1xuXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIChpdCkge1xuICBpZiAoIWlzT2JqZWN0KGl0KSkge1xuICAgIHRocm93IFR5cGVFcnJvcihTdHJpbmcoaXQpICsgJyBpcyBub3QgYW4gb2JqZWN0Jyk7XG4gIH0gcmV0dXJuIGl0O1xufTtcbiIsInZhciBmYWlscyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9mYWlscycpO1xuXG4vLyBUaGFuaydzIElFOCBmb3IgaGlzIGZ1bm55IGRlZmluZVByb3BlcnR5XG5tb2R1bGUuZXhwb3J0cyA9ICFmYWlscyhmdW5jdGlvbiAoKSB7XG4gIHJldHVybiBPYmplY3QuZGVmaW5lUHJvcGVydHkoe30sIDEsIHsgZ2V0OiBmdW5jdGlvbiAoKSB7IHJldHVybiA3OyB9IH0pWzFdICE9IDc7XG59KTtcbiIsInZhciBnbG9iYWwgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZ2xvYmFsJyk7XG52YXIgaXNPYmplY3QgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvaXMtb2JqZWN0Jyk7XG5cbnZhciBkb2N1bWVudCA9IGdsb2JhbC5kb2N1bWVudDtcbi8vIHR5cGVvZiBkb2N1bWVudC5jcmVhdGVFbGVtZW50IGlzICdvYmplY3QnIGluIG9sZCBJRVxudmFyIEVYSVNUUyA9IGlzT2JqZWN0KGRvY3VtZW50KSAmJiBpc09iamVjdChkb2N1bWVudC5jcmVhdGVFbGVtZW50KTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiAoaXQpIHtcbiAgcmV0dXJuIEVYSVNUUyA/IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoaXQpIDoge307XG59O1xuIiwibW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiAoZXhlYykge1xuICB0cnkge1xuICAgIHJldHVybiAhIWV4ZWMoKTtcbiAgfSBjYXRjaCAoZXJyb3IpIHtcbiAgICByZXR1cm4gdHJ1ZTtcbiAgfVxufTtcbiIsInZhciBjaGVjayA9IGZ1bmN0aW9uIChpdCkge1xuICByZXR1cm4gaXQgJiYgaXQuTWF0aCA9PSBNYXRoICYmIGl0O1xufTtcblxuLy8gaHR0cHM6Ly9naXRodWIuY29tL3psb2lyb2NrL2NvcmUtanMvaXNzdWVzLzg2I2lzc3VlY29tbWVudC0xMTU3NTkwMjhcbm1vZHVsZS5leHBvcnRzID1cbiAgLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLXVuZGVmXG4gIGNoZWNrKHR5cGVvZiBnbG9iYWxUaGlzID09ICdvYmplY3QnICYmIGdsb2JhbFRoaXMpIHx8XG4gIGNoZWNrKHR5cGVvZiB3aW5kb3cgPT0gJ29iamVjdCcgJiYgd2luZG93KSB8fFxuICBjaGVjayh0eXBlb2Ygc2VsZiA9PSAnb2JqZWN0JyAmJiBzZWxmKSB8fFxuICBjaGVjayh0eXBlb2YgZ2xvYmFsID09ICdvYmplY3QnICYmIGdsb2JhbCkgfHxcbiAgLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIG5vLW5ldy1mdW5jXG4gIEZ1bmN0aW9uKCdyZXR1cm4gdGhpcycpKCk7XG4iLCJ2YXIgREVTQ1JJUFRPUlMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZGVzY3JpcHRvcnMnKTtcbnZhciBmYWlscyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9mYWlscycpO1xudmFyIGNyZWF0ZUVsZW1lbnQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZG9jdW1lbnQtY3JlYXRlLWVsZW1lbnQnKTtcblxuLy8gVGhhbmsncyBJRTggZm9yIGhpcyBmdW5ueSBkZWZpbmVQcm9wZXJ0eVxubW9kdWxlLmV4cG9ydHMgPSAhREVTQ1JJUFRPUlMgJiYgIWZhaWxzKGZ1bmN0aW9uICgpIHtcbiAgcmV0dXJuIE9iamVjdC5kZWZpbmVQcm9wZXJ0eShjcmVhdGVFbGVtZW50KCdkaXYnKSwgJ2EnLCB7XG4gICAgZ2V0OiBmdW5jdGlvbiAoKSB7IHJldHVybiA3OyB9XG4gIH0pLmEgIT0gNztcbn0pO1xuIiwibW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiAoaXQpIHtcbiAgcmV0dXJuIHR5cGVvZiBpdCA9PT0gJ29iamVjdCcgPyBpdCAhPT0gbnVsbCA6IHR5cGVvZiBpdCA9PT0gJ2Z1bmN0aW9uJztcbn07XG4iLCJ2YXIgREVTQ1JJUFRPUlMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZGVzY3JpcHRvcnMnKTtcbnZhciBJRThfRE9NX0RFRklORSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9pZTgtZG9tLWRlZmluZScpO1xudmFyIGFuT2JqZWN0ID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2FuLW9iamVjdCcpO1xudmFyIHRvUHJpbWl0aXZlID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3RvLXByaW1pdGl2ZScpO1xuXG52YXIgbmF0aXZlRGVmaW5lUHJvcGVydHkgPSBPYmplY3QuZGVmaW5lUHJvcGVydHk7XG5cbi8vIGBPYmplY3QuZGVmaW5lUHJvcGVydHlgIG1ldGhvZFxuLy8gaHR0cHM6Ly90YzM5LmdpdGh1Yi5pby9lY21hMjYyLyNzZWMtb2JqZWN0LmRlZmluZXByb3BlcnR5XG5leHBvcnRzLmYgPSBERVNDUklQVE9SUyA/IG5hdGl2ZURlZmluZVByb3BlcnR5IDogZnVuY3Rpb24gZGVmaW5lUHJvcGVydHkoTywgUCwgQXR0cmlidXRlcykge1xuICBhbk9iamVjdChPKTtcbiAgUCA9IHRvUHJpbWl0aXZlKFAsIHRydWUpO1xuICBhbk9iamVjdChBdHRyaWJ1dGVzKTtcbiAgaWYgKElFOF9ET01fREVGSU5FKSB0cnkge1xuICAgIHJldHVybiBuYXRpdmVEZWZpbmVQcm9wZXJ0eShPLCBQLCBBdHRyaWJ1dGVzKTtcbiAgfSBjYXRjaCAoZXJyb3IpIHsgLyogZW1wdHkgKi8gfVxuICBpZiAoJ2dldCcgaW4gQXR0cmlidXRlcyB8fCAnc2V0JyBpbiBBdHRyaWJ1dGVzKSB0aHJvdyBUeXBlRXJyb3IoJ0FjY2Vzc29ycyBub3Qgc3VwcG9ydGVkJyk7XG4gIGlmICgndmFsdWUnIGluIEF0dHJpYnV0ZXMpIE9bUF0gPSBBdHRyaWJ1dGVzLnZhbHVlO1xuICByZXR1cm4gTztcbn07XG4iLCJ2YXIgaXNPYmplY3QgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvaXMtb2JqZWN0Jyk7XG5cbi8vIGBUb1ByaW1pdGl2ZWAgYWJzdHJhY3Qgb3BlcmF0aW9uXG4vLyBodHRwczovL3RjMzkuZ2l0aHViLmlvL2VjbWEyNjIvI3NlYy10b3ByaW1pdGl2ZVxuLy8gaW5zdGVhZCBvZiB0aGUgRVM2IHNwZWMgdmVyc2lvbiwgd2UgZGlkbid0IGltcGxlbWVudCBAQHRvUHJpbWl0aXZlIGNhc2Vcbi8vIGFuZCB0aGUgc2Vjb25kIGFyZ3VtZW50IC0gZmxhZyAtIHByZWZlcnJlZCB0eXBlIGlzIGEgc3RyaW5nXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIChpbnB1dCwgUFJFRkVSUkVEX1NUUklORykge1xuICBpZiAoIWlzT2JqZWN0KGlucHV0KSkgcmV0dXJuIGlucHV0O1xuICB2YXIgZm4sIHZhbDtcbiAgaWYgKFBSRUZFUlJFRF9TVFJJTkcgJiYgdHlwZW9mIChmbiA9IGlucHV0LnRvU3RyaW5nKSA9PSAnZnVuY3Rpb24nICYmICFpc09iamVjdCh2YWwgPSBmbi5jYWxsKGlucHV0KSkpIHJldHVybiB2YWw7XG4gIGlmICh0eXBlb2YgKGZuID0gaW5wdXQudmFsdWVPZikgPT0gJ2Z1bmN0aW9uJyAmJiAhaXNPYmplY3QodmFsID0gZm4uY2FsbChpbnB1dCkpKSByZXR1cm4gdmFsO1xuICBpZiAoIVBSRUZFUlJFRF9TVFJJTkcgJiYgdHlwZW9mIChmbiA9IGlucHV0LnRvU3RyaW5nKSA9PSAnZnVuY3Rpb24nICYmICFpc09iamVjdCh2YWwgPSBmbi5jYWxsKGlucHV0KSkpIHJldHVybiB2YWw7XG4gIHRocm93IFR5cGVFcnJvcihcIkNhbid0IGNvbnZlcnQgb2JqZWN0IHRvIHByaW1pdGl2ZSB2YWx1ZVwiKTtcbn07XG4iLCJ2YXIgREVTQ1JJUFRPUlMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZGVzY3JpcHRvcnMnKTtcbnZhciBkZWZpbmVQcm9wZXJ0eSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9vYmplY3QtZGVmaW5lLXByb3BlcnR5JykuZjtcblxudmFyIEZ1bmN0aW9uUHJvdG90eXBlID0gRnVuY3Rpb24ucHJvdG90eXBlO1xudmFyIEZ1bmN0aW9uUHJvdG90eXBlVG9TdHJpbmcgPSBGdW5jdGlvblByb3RvdHlwZS50b1N0cmluZztcbnZhciBuYW1lUkUgPSAvXlxccypmdW5jdGlvbiAoW14gKF0qKS87XG52YXIgTkFNRSA9ICduYW1lJztcblxuLy8gRnVuY3Rpb24gaW5zdGFuY2VzIGAubmFtZWAgcHJvcGVydHlcbi8vIGh0dHBzOi8vdGMzOS5naXRodWIuaW8vZWNtYTI2Mi8jc2VjLWZ1bmN0aW9uLWluc3RhbmNlcy1uYW1lXG5pZiAoREVTQ1JJUFRPUlMgJiYgIShOQU1FIGluIEZ1bmN0aW9uUHJvdG90eXBlKSkge1xuICBkZWZpbmVQcm9wZXJ0eShGdW5jdGlvblByb3RvdHlwZSwgTkFNRSwge1xuICAgIGNvbmZpZ3VyYWJsZTogdHJ1ZSxcbiAgICBnZXQ6IGZ1bmN0aW9uICgpIHtcbiAgICAgIHRyeSB7XG4gICAgICAgIHJldHVybiBGdW5jdGlvblByb3RvdHlwZVRvU3RyaW5nLmNhbGwodGhpcykubWF0Y2gobmFtZVJFKVsxXTtcbiAgICAgIH0gY2F0Y2ggKGVycm9yKSB7XG4gICAgICAgIHJldHVybiAnJztcbiAgICAgIH1cbiAgICB9XG4gIH0pO1xufVxuIiwidmFyIGc7XG5cbi8vIFRoaXMgd29ya3MgaW4gbm9uLXN0cmljdCBtb2RlXG5nID0gKGZ1bmN0aW9uKCkge1xuXHRyZXR1cm4gdGhpcztcbn0pKCk7XG5cbnRyeSB7XG5cdC8vIFRoaXMgd29ya3MgaWYgZXZhbCBpcyBhbGxvd2VkIChzZWUgQ1NQKVxuXHRnID0gZyB8fCBuZXcgRnVuY3Rpb24oXCJyZXR1cm4gdGhpc1wiKSgpO1xufSBjYXRjaCAoZSkge1xuXHQvLyBUaGlzIHdvcmtzIGlmIHRoZSB3aW5kb3cgcmVmZXJlbmNlIGlzIGF2YWlsYWJsZVxuXHRpZiAodHlwZW9mIHdpbmRvdyA9PT0gXCJvYmplY3RcIikgZyA9IHdpbmRvdztcbn1cblxuLy8gZyBjYW4gc3RpbGwgYmUgdW5kZWZpbmVkLCBidXQgbm90aGluZyB0byBkbyBhYm91dCBpdC4uLlxuLy8gV2UgcmV0dXJuIHVuZGVmaW5lZCwgaW5zdGVhZCBvZiBub3RoaW5nIGhlcmUsIHNvIGl0J3Ncbi8vIGVhc2llciB0byBoYW5kbGUgdGhpcyBjYXNlLiBpZighZ2xvYmFsKSB7IC4uLn1cblxubW9kdWxlLmV4cG9ydHMgPSBnO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==