jQuery(function(){

    var userAgent = navigator.userAgent.toLowerCase();

    jQuery('[rel=tooltip]').tooltip();
    jQuery('[rel=popover]').popover({placement:'right', trigger:'hover', container:'body'});

    jQuery('input.datepicker').each(function(i, item){

        jQuery(item).datepicker({
            dateFormat:'yy-mm-dd'
        });
    });

    if(window.prettyPrint != undefined && jQuery.isFunction(window.prettyPrint)){

        prettyPrint();
    }

    var stickyFooter = function(){

        var height = jQuery('#sticky_footer').height();

        if (/msie/.test(userAgent) && parseFloat((userAgent.match(/.*(?:rv|ie)[\/: ](.+?)([ \);]|$)/) || [])[1]) > 7) {

            height=height+5;
        }

        jQuery('#sticky_footer_push').css('height', (height)+'px');
        jQuery('#sticky_footer_wrap').css('margin-bottom', -(height)+'px');
    };

    jQuery(window).on('resize', stickyFooter);

    stickyFooter();

    setTimeout(function () {
      jQuery('.sidebar-affix').affix({
        offset: {
          top: function(){

              if (/msie/.test(userAgent) && parseFloat((userAgent.match(/.*(?:rv|ie)[\/: ](.+?)([ \);]|$)/) || [])[1]) >= 9) {

                  return jQuery('#header').height()+(jQuery('#navbar_fixed_top_collapse_button:visible').attr('id') ? 8 : -32)
              }
              else{

                  return jQuery('#header').height()+(jQuery('#navbar_fixed_top_collapse_button:visible').attr('id') ? 90 : 50)
              }
          },
          bottom: 120
        }
      })
    }, 100);

    jQuery('body').scrollspy();
});
