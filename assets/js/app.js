/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
// uncomment to support legacy code
// global.$ = $;

import 'bootstrap'; // adds functions to jQuery
import 'bootstrap-datepicker';

import './components/get_nice_message';


$(function() {
    // Persistencia del último TAB seleccionado
    $('a[data-toggle="tab"]').on('click', function(e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
        window.localStorage.removeItem("activeTab");
    }
});

// Correción del fallo en input-files de bootstrap 4
$('.custom-file-input').on('change', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);

    $('.collapse').collapse();
});



$(function () {
    $('[data-toggle="popover"]').popover({
        trigger: 'focus'
    })
})
