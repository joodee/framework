jQuery(function(){

    jQuery('input.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    }).on('changeDate', function(ev) {
        if(ev.viewMode=='days'){
            $(this).datepicker('hide');
        }
    });
});
