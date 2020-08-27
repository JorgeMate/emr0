(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["delete"],{

/***/ "./assets/css/delete_record.scss":
/*!***************************************!*\
  !*** ./assets/css/delete_record.scss ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./assets/js/delete_record.js":
/*!************************************!*\
  !*** ./assets/js/delete_record.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _css_delete_record_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../css/delete_record.scss */ "./assets/css/delete_record.scss");
/* harmony import */ var _css_delete_record_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_delete_record_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);


var Record = {
  initialize: function ($wrapper) {
    this.$wrapper = $wrapper;
    this.$wrapper.find('.js-delete-record').on('click', this.handleRecordDelete);
  },
  handleRecordDelete: function (e) {
    e.preventDefault();
    jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).addClass('text-danger');
    jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');
    var $row = jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).closest('tr');
    var deleteUrl = jquery__WEBPACK_IMPORTED_MODULE_1___default()(this).data('url');
    jquery__WEBPACK_IMPORTED_MODULE_1___default.a.ajax({
      url: deleteUrl,
      method: 'DELETE',
      success: function () {
        $row.fadeOut();
      }
    });
  }
};
jquery__WEBPACK_IMPORTED_MODULE_1___default()(document).ready(function () {
  var $tableOperas = jquery__WEBPACK_IMPORTED_MODULE_1___default()('.js-operas-table');
  Record.initialize($tableOperas);
  var $tableImgs = jquery__WEBPACK_IMPORTED_MODULE_1___default()('.js-imgs-table');
  Record.initialize($tableImgs);
  var $tableDocs = jquery__WEBPACK_IMPORTED_MODULE_1___default()('.js-docs-table');
  Record.initialize($tableDocs);
});

/***/ })

},[["./assets/js/delete_record.js","runtime","vendors~app~delete~dp_en~dp_es~dp_fr~dp_nl~med_stop~search_p~sel_treat"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY3NzL2RlbGV0ZV9yZWNvcmQuc2NzcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZGVsZXRlX3JlY29yZC5qcyJdLCJuYW1lcyI6WyJSZWNvcmQiLCJpbml0aWFsaXplIiwiJHdyYXBwZXIiLCJmaW5kIiwib24iLCJoYW5kbGVSZWNvcmREZWxldGUiLCJlIiwicHJldmVudERlZmF1bHQiLCIkIiwiYWRkQ2xhc3MiLCJyZW1vdmVDbGFzcyIsIiRyb3ciLCJjbG9zZXN0IiwiZGVsZXRlVXJsIiwiZGF0YSIsImFqYXgiLCJ1cmwiLCJtZXRob2QiLCJzdWNjZXNzIiwiZmFkZU91dCIsImRvY3VtZW50IiwicmVhZHkiLCIkdGFibGVPcGVyYXMiLCIkdGFibGVJbWdzIiwiJHRhYmxlRG9jcyJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUEsdUM7Ozs7Ozs7Ozs7OztBQ0FBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBRUEsSUFBSUEsTUFBTSxHQUFHO0FBRVRDLFlBQVUsRUFBRSxVQUFTQyxRQUFULEVBQW1CO0FBQzNCLFNBQUtBLFFBQUwsR0FBZ0JBLFFBQWhCO0FBQ0EsU0FBS0EsUUFBTCxDQUFjQyxJQUFkLENBQW1CLG1CQUFuQixFQUF3Q0MsRUFBeEMsQ0FDSSxPQURKLEVBRUksS0FBS0Msa0JBRlQ7QUFJSCxHQVJRO0FBVVRBLG9CQUFrQixFQUFFLFVBQVNDLENBQVQsRUFBWTtBQUM1QkEsS0FBQyxDQUFDQyxjQUFGO0FBRUFDLGlEQUFDLENBQUMsSUFBRCxDQUFELENBQVFDLFFBQVIsQ0FBaUIsYUFBakI7QUFFQUQsaURBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUUwsSUFBUixDQUFhLEtBQWIsRUFDQ08sV0FERCxDQUNhLFVBRGIsRUFFS0QsUUFGTCxDQUVjLFlBRmQsRUFHS0EsUUFITCxDQUdjLFNBSGQ7QUFLQSxRQUFJRSxJQUFJLEdBQUdILDZDQUFDLENBQUMsSUFBRCxDQUFELENBQVFJLE9BQVIsQ0FBZ0IsSUFBaEIsQ0FBWDtBQUNBLFFBQUlDLFNBQVMsR0FBR0wsNkNBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUU0sSUFBUixDQUFhLEtBQWIsQ0FBaEI7QUFFQU4saURBQUMsQ0FBQ08sSUFBRixDQUFPO0FBQ0hDLFNBQUcsRUFBRUgsU0FERjtBQUVISSxZQUFNLEVBQUUsUUFGTDtBQUdIQyxhQUFPLEVBQUUsWUFBVztBQUNoQlAsWUFBSSxDQUFDUSxPQUFMO0FBQ0g7QUFMRSxLQUFQO0FBT0g7QUE5QlEsQ0FBYjtBQXFDQVgsNkNBQUMsQ0FBQ1ksUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBVztBQUV6QixNQUFJQyxZQUFZLEdBQUdkLDZDQUFDLENBQUMsa0JBQUQsQ0FBcEI7QUFDQVIsUUFBTSxDQUFDQyxVQUFQLENBQWtCcUIsWUFBbEI7QUFFQSxNQUFJQyxVQUFVLEdBQUdmLDZDQUFDLENBQUMsZ0JBQUQsQ0FBbEI7QUFDQVIsUUFBTSxDQUFDQyxVQUFQLENBQWtCc0IsVUFBbEI7QUFFQSxNQUFJQyxVQUFVLEdBQUdoQiw2Q0FBQyxDQUFDLGdCQUFELENBQWxCO0FBQ0FSLFFBQU0sQ0FBQ0MsVUFBUCxDQUFrQnVCLFVBQWxCO0FBRUgsQ0FYRCxFIiwiZmlsZSI6ImRlbGV0ZS5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsImltcG9ydCAnLi4vY3NzL2RlbGV0ZV9yZWNvcmQuc2Nzcyc7XG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuXG52YXIgUmVjb3JkID0ge1xuXG4gICAgaW5pdGlhbGl6ZTogZnVuY3Rpb24oJHdyYXBwZXIpIHtcbiAgICAgICAgdGhpcy4kd3JhcHBlciA9ICR3cmFwcGVyO1xuICAgICAgICB0aGlzLiR3cmFwcGVyLmZpbmQoJy5qcy1kZWxldGUtcmVjb3JkJykub24oXG4gICAgICAgICAgICAnY2xpY2snLFxuICAgICAgICAgICAgdGhpcy5oYW5kbGVSZWNvcmREZWxldGVcbiAgICAgICAgKTtcbiAgICB9LFxuXG4gICAgaGFuZGxlUmVjb3JkRGVsZXRlOiBmdW5jdGlvbihlKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICAkKHRoaXMpLmFkZENsYXNzKCd0ZXh0LWRhbmdlcicpO1xuXG4gICAgICAgICQodGhpcykuZmluZCgnLmZhJylcbiAgICAgICAgLnJlbW92ZUNsYXNzKCdmYS10cmFzaCcpXG4gICAgICAgICAgICAuYWRkQ2xhc3MoJ2ZhLXNwaW5uZXInKVxuICAgICAgICAgICAgLmFkZENsYXNzKCdmYS1zcGluJyk7XG5cbiAgICAgICAgdmFyICRyb3cgPSAkKHRoaXMpLmNsb3Nlc3QoJ3RyJyk7XG4gICAgICAgIHZhciBkZWxldGVVcmwgPSAkKHRoaXMpLmRhdGEoJ3VybCcpO1xuXG4gICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICB1cmw6IGRlbGV0ZVVybCxcbiAgICAgICAgICAgIG1ldGhvZDogJ0RFTEVURScsXG4gICAgICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAkcm93LmZhZGVPdXQoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgfSxcblxufTtcblxuXG5cblxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG5cbiAgICB2YXIgJHRhYmxlT3BlcmFzID0gJCgnLmpzLW9wZXJhcy10YWJsZScpO1xuICAgIFJlY29yZC5pbml0aWFsaXplKCR0YWJsZU9wZXJhcyk7XG5cbiAgICB2YXIgJHRhYmxlSW1ncyA9ICQoJy5qcy1pbWdzLXRhYmxlJyk7XG4gICAgUmVjb3JkLmluaXRpYWxpemUoJHRhYmxlSW1ncyk7XG5cbiAgICB2YXIgJHRhYmxlRG9jcyA9ICQoJy5qcy1kb2NzLXRhYmxlJyk7XG4gICAgUmVjb3JkLmluaXRpYWxpemUoJHRhYmxlRG9jcyk7XG5cbn0pO1xuXG5cblxuXG5cblxuXG5cbiJdLCJzb3VyY2VSb290IjoiIn0=