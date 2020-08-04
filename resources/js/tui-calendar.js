/**
 * Tui Calendar
 * https://github.com/nhn/tui.calendar
 */

// --------------------------------------------------------WIP---------------------------------------------

import Calendar from 'tui-calendar'; /* ES6 */
import "tui-calendar/dist/tui-calendar.css";

// If you use the default popups, use this.
import 'tui-date-picker/dist/tui-date-picker.css';
import 'tui-time-picker/dist/tui-time-picker.css';
// -------------


$('.calendar-doctor-schedule').each(function() {

    var $calendar = $(this).tuiCalendar({
        usageStatistics: false,
        defaultView: 'month'
    });

    // You can get calendar instance
    var calendarInstance = $calendar.data('tuiCalendar');

    calendarInstance.createSchedules([ //
        {
            id: '1',
            calendarId: '1',
            title: 'my schedule',
            category: 'time',
            dueDateClass: '',
            start: '2020-08-18T22:30:00+09:00',
            end: '2020-08-19T02:30:00+09:00'
        },
        {
            id: '2',
            calendarId: '1',
            title: 'second schedule',
            category: 'time',
            dueDateClass: '',
            start: '2020-08-18T17:30:00+09:00',
            end: '2020-08-19T17:31:00+09:00'
        }
    ]);
})
