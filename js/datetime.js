$(document).ready(function() {



    $('.date_picker').datetimepicker({
        formatTime:'H:i',
        formatDate:'d.m.Y',
        format:'Y-m-d H:i',
        defaultDate:'30.08.2014', // it's my birthday
        defaultTime:'10:00',
        lang:'ru',
        startDate:	'2015/04/30'
    });

 /*   $('#date_start').datetimepicker({
        formatTime:'H:i',
        formatDate:'d.m.Y',
        format:'Y-m-d H:i',
        defaultDate:'30.08.2014', // it's my birthday
        defaultTime:'10:00',
        lang:'ru',
        startDate:	'2015/04/30'
    })*/


});