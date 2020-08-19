/**
 * jQuery UI
 * https://api.jqueryui.com/
 * https://github.com/jquery/jquery-ui
 */

window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/autocomplete';
import 'jquery-ui/ui/widgets/datepicker';
import 'jquery-ui/ui/i18n/datepicker-id'; // Import datepicker Indonesia language
// --


/**
 * Datepicker
 */
$('input.datepicker').each(function() {
    initDatepicker($(this));
})

function initDatepicker(element) {
    let options = {
        dateFormat: 'yy-mm-dd',
        yearRange: 'c-100:c+100' // Set year range selection 100
    };

    // Enable change month & year
    let dataChangeMonth = $(element).data('change-month');
    let dataChangeYear = $(element).data('change-year');
    if (dataChangeMonth) options.changeMonth = true;
    if (dataChangeYear) options.changeYear = true;

    // Smart check min date
    let dataMinDate = $(element).data('min-date');
    switch (typeof dataMinDate) {
        case 'object':
            options.minDate = new Date(dataMinDate);
            break;
        case 'number':
        case 'string':
            options.minDate = dataMinDate;
            break;
        default:
            break;
    }

    // Smart check max date
    let dataMaxDate = $(element).data('max-date');
    switch (typeof dataMaxDate) {
        case 'object':
            options.maxDate = new Date(dataMaxDate);
            break;
        case 'number':
        case 'string':
            options.maxDate = dataMaxDate;
            break;
        default:
            break;
    }

    // Set date format
    let dataFormat = $(element).data('format');
    let dataAltFormat = $(element).data('alt-format');
    if (dataFormat != undefined) options.dateFormat = dataFormat;

    // Set date format for display and true format into alt input
    if (dataAltFormat != undefined) {
        let altInput = $('<input>');
        altInput.attr('type', 'hidden');
        altInput.attr('name', $(element).attr('name'));

        // If value defined - Set value for alt input
        let dateValue = $(element).val();
        let altDateValue = $.datepicker.formatDate(dataAltFormat, new Date(dateValue));
        if (dateValue) {
            altInput.val(dateValue);
            $(element).val(altDateValue);
        }

        $(element).after(altInput);
        $(element).removeAttr('name');

        options.altField = altInput;
        if (dataFormat == undefined) {
            options.altFormat = 'yy-mm-dd';
            options.dateFormat = dataAltFormat;
        } else {
            options.altFormat = dataFormat;
            options.dateFormat = dataAltFormat;
        }
    }

    // Set close dates from array data attribute
    let dataCloseDates = $(element).data('close-dates');
    if (dataCloseDates != undefined) {
        options.beforeShowDay = function(date) {
            var string = $.datepicker.formatDate('yy/mm/dd', date);
            return [dataCloseDates.indexOf(string) == -1];
        }
    }

    // Set datepicker languange
    let lang = $('html').attr('lang');
    $.datepicker.setDefaults($.datepicker.regional[lang]);

    $(element).datepicker(options);
}
