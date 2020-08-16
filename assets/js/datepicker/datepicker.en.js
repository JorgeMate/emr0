import '../../css/bootstrap-datepicker.standalone.min.scss';

import $ from 'jquery';

$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        todayBtn: "linked",
        language: "en",
        daysOfWeekHighlighted: "0,6",
        autoclose: true
    });
});