jQuery(function(){

    jQuery(".login-form").validate({
        rules:{
            username:'required',
            password:'required',
            captcha_code:'required'
        },
        errorPlacement: function(error, element) {
          jQuery(element).closest('.form-group').find('.error-block').remove();
          jQuery(element).closest('.form-group').find('div:first').append(jQuery(error).addClass('help-block'));
        },
        highlight: function(element, errorClass, validClass) {
          jQuery(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          jQuery(element).closest('.form-group').removeClass('has-error').find('.error-block').remove();
        },
        submitHandler: function(form) {
            document.cookie = "TestCookie=1; path=/; domain=." + window.location.hostname;
            form.submit();
        },
        errorElement: 'span',
        errorClass: 'error-block'
    });

    jQuery('.login-modal-button').on('click', function(){
        jQuery('#captcha_authentication_modal').attr('src', jQuery('#captcha_authentication_modal').attr('src')+Math.floor(Math.random()*10));
        jQuery('.login-form-modal').modal();
        return false;
    });

    jQuery('.login-form-modal .btn-close').on('click', function(){
        jQuery(this).closest('.login-form-modal').modal('hide');
    });

    if(!jQuery.support.placeholder){

        jQuery('.support-placeholder').show();
    }
});

if(jQuery.support.placeholder==undefined){

    jQuery.support.placeholder = (function(){

        var i = document.createElement('input');
        return 'placeholder' in i;
    })();
}

function bindPhoneFieldEvents(phoneInputSelector, locationInputSelector, flagIconWrapperSelector, locationList, defaultLocationCode){

    var flagHeight = 11;

    jQuery(phoneInputSelector).on('keyup', function(){

        var phone = this.value;
        var count = 0;
        var found = '';

        jQuery.each(locationList, function(cc, item){
            if(phone.substr(phone.substr(0, 1)=='+'?1:0, item.phone.length) == item.phone && item.phone.length>count && jQuery.inArray(cc, ['pg'])==-1){
                if((cc=='ca' && defaultLocationCode!='ca') || (cc=='mp' && defaultLocationCode!='mp')){

                    count = locationList['us'].phone.length;
                    found = 'us';
                }
                else if(cc=='kz' && defaultLocationCode!='kz'){

                    count = locationList['ru'].phone.length;
                    found = 'ru';
                }
                else if(cc=='kp' && defaultLocationCode!='kp'){

                    count = locationList['kr'].phone.length;
                    found = 'kr';
                }
                else if(cc=='pg' && defaultLocationCode!='pg'){

                    count = locationList['ph'].phone.length;
                    found = 'ph';
                }
                else{

                    count = item.phone.length;
                    found = cc;
                }
            }
        });

        if(locationList[found] == undefined){
            found = defaultLocationCode;
        }

        jQuery(flagIconWrapperSelector + ' .icon-location-flag').css('background-position', '0 -' + (locationList[found].flag*flagHeight) +'px');
    });

    jQuery(locationInputSelector).autocomplete({
        appendTo:jQuery(phoneInputSelector).parent().parent(),
        minLength: 0,
        width: 200,
        source: function(request, response){

            var input = jQuery(locationInputSelector);

            str = input.val().charAt(input.val().length-1);

            input.val('');

            return response(jQuery.map( locationList, function(item, cc) {

                if(item.phone=='' || item.name.substr(0, str.length).toLowerCase() != str.toLowerCase()){

                  return null;
                }

                return {value:cc, label:'<span class="icon-location-flag" style="background-position: 0 -' + (item.flag*flagHeight) + 'px;"></span> ' + item.name + (item.local?' ('+item.local+')':'') +(item.phone?' <span class="phone-location-code">+' + item.phone+'</span>':'')}
            }));
        },
        select: function(event, ui) {

            jQuery(phoneInputSelector).focus();
            jQuery(phoneInputSelector).val('');
            jQuery(phoneInputSelector).val('+'+locationList[ui.item.value].phone);
            jQuery(flagIconWrapperSelector + ' .icon-location-flag').css('background-position', '0 -' + (locationList[ui.item.value].flag*flagHeight) +'px');
        },
        open: function(event, ui){
            jQuery(phoneInputSelector).parent().parent().find('.ui-autocomplete').css({left:0,top:-1});
        },
        create: function(event, ui){

            if(jQuery(phoneInputSelector).val()){

                jQuery(phoneInputSelector).keyup();
            }
            else{

                jQuery(phoneInputSelector).val('+'+locationList[defaultLocationCode].phone);
                jQuery(flagIconWrapperSelector + ' .icon-location-flag').css('background-position', '0 -' + (locationList[defaultLocationCode].flag*flagHeight) +'px');
            }
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
         return $("<li></li>")
             .data("item.autocomplete", item)
             .append(item.label)
             .appendTo(ul);
     };

    jQuery('.ui-autocomplete:last').addClass('ui-autocomplete-mobile-phone-location');

    jQuery(flagIconWrapperSelector).on('click', function(){

        jQuery(locationInputSelector).val('').autocomplete('search', '').focus();
    });
}
