import $ from 'jquery';

$(document).ready(function() {
    $('.js-datepicker').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        todayBtn: "linked",
        language: "fr",
        daysOfWeekHighlighted: "0,6",
        autoclose: true
    });
});