/**
 * Generic Javascript for Mahoney System
 */
$(document).ready(function() {

    if ($(".table").length > 0) {
        $(".table").tablesorter();
    }
    
    if($("[data-action=\"batch-toggle\"]").length > 0) {
        $("[data-action=\"batch-toggle\"]").click(function(){
            var parentElement = $(this);
            $("[data-target=\"batch\"]").each(function(){
                $(this).prop("checked", parentElement.prop("checked"));
            });
        });
    }
    
    if($("#BatchAction").length > 0) {
        $("#BatchAction").change(function(){
            if($(this).val() != "") {
                $(".batch-objects").html("");
                $("[data-target=\"batch\"]").each(function(){
                    if($(this).is(":checked")){
                        var howMany = $('.batch-element').length;
                        $(".batch-objects").append(''+
                            '<input class="batch-element" name="data[Batch]['+howMany+'][id]" value="'+$(this).data("post")+'">'+
                        '');
                    }
                });
                if($('.batch-element').length > 0) {
                    var q = confirm($("#BatchAction").data("confirm"));
                    if(q) {
                        $('#BatchAction').parent("form").submit();
                    }
                }
            }
        });
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