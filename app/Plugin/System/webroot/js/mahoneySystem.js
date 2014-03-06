/**
 * Generic Javascript for Mahoney System
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

/* Bootstrap N-LEVEL menu */
$(function() {
    $(".dropdown-menu > li > a.trigger").on("click", function(e) {
        var current = $(this).next();
        var grandparent = $(this).parent().parent();
        if ($(this).hasClass('left-caret') || $(this).hasClass('right-caret'))
            $(this).toggleClass('right-caret left-caret');
        grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
        grandparent.find(".sub-menu:visible").not(current).hide();
        current.toggle();
        e.stopPropagation();
    });
    $(".dropdown-menu > li > a:not(.trigger)").on("click", function() {
        var root = $(this).closest('.dropdown');
        root.find('.left-caret').toggleClass('right-caret left-caret');
        root.find('.sub-menu:visible').hide();
    });
});