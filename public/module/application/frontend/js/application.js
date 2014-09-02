jQuery(function(){

    jQuery('[rel=tooltip]').tooltip();
    jQuery('[rel=popover]').popover({placement:'right', trigger:'hover', container:'body'});

    if(window.prettyPrint != undefined && jQuery.isFunction(window.prettyPrint)){

        prettyPrint();
    }

    $('input.autodatepicker').datepicker({
        format: 'yyyy-mm-dd'
    }).on('changeDate', function(ev) {
        if(ev.viewMode=='days'){
            $(this).datepicker('hide').change().blur();
        }
    });
});
