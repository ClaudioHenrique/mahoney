/**
 * Generic Javascript for Mahoney
 */
$(document).ready(function() {
 
    if ($(".table").length > 0) {
        $(".table").tablesorter();
    }

    if ($('.tooltipElement').length > 0) {
        $('.tooltipElement').tooltip();
    }

    if ($("#liveSearchActivityLog").length > 0) {
        $('#liveSearchActivityLog').keyup(function() {
            var typedVal = $(this).val();
            if (typedVal.length > 2) {
                $("td.activityCel").parent('tr').addClass('hide');
                $("td.activityCel").each(function() {
                    if ($(this).html().toString().toLowerCase().indexOf(typedVal.toString().toLowerCase()) >= 0) {
                        $(this).parent('tr').removeClass('hide');
                    }
                });
            } else if (typedVal.length <= 2) {
                $("td.activityCel").parent('tr').removeClass('hide');
            }
        });
    }
});