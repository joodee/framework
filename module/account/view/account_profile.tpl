<div class="controller account-profile well">

  <div class="page-header">
    <h2>Your profile</h2>
  </div>
  <script type="text/javascript">

  var locationList = {CountryList::getItems(true, 'us')|json_encode};
  var defaultLocationCode = '{CountryList::getRemoteLocationCode('us')}';

  jQuery(function(){

    jQuery('#account_profile_form').validate({
      rules: {
        nickname: {
          required:true,
          maxlength: 32
        },
        first_name: {
          required:true,
          maxlength: 32
        },
        last_name: {
          required: true,
          maxlength: 32
        },
        birthday_day: {
            required: true,
            number: true,
            maxlength: 2,
            range: [1,31]
        },
        birthday_month: {
            required: true,
            number: true,
            range: [1,12]
        },
        birthday_year: {
            required: true,
            number: true,
            maxlength: 4,
            range: [new Date().getFullYear()-120, new Date().getFullYear()]
        },
        gender: {
          required: true
        },
        mobile_phone: {
            required: true,
            rangelength: [11,14],
            pattern: /^[\+][0-9]+$/
        },
        email: {
          required: true,
          email: true,
          maxlength: 64
        },
        location_iso2: {
            required: true
        },
        timezone_area: {
            required: true
        },
        timezone_value: {
            required: true
        }
      },
      messages: {
        first_name: {
          required: "{AccountIntl::$validation_nickname_required|escape}",
          maxlength: "{AccountIntl::$validation_nickname_length_max|escape}"
        },
        first_name: {
          required: "{AccountIntl::$validation_first_name_required|escape}",
          maxlength: "{AccountIntl::$validation_first_name_length_max|escape}"
        },
        last_name: {
          required: "{AccountIntl::$validation_last_name_required|escape}",
          maxlength: "{AccountIntl::$validation_last_name_length_max|escape}"
        },
        birthday_day: {
            required: "{AccountIntl::$validation_birthday_date_required|escape}",
            number: "{AccountIntl::$validation_birthday_date_not_valid|escape}",
            maxlength: "{AccountIntl::$validation_birthday_date_not_valid|escape}",
            range: "{AccountIntl::$validation_birthday_date_not_valid|escape}"
        },
        birthday_month: {
            required: "{AccountIntl::$validation_birthday_month_required|escape}",
            number: "{AccountIntl::$validation_birthday_month_not_valid|escape}",
            range: "{AccountIntl::$validation_birthday_month_not_valid|escape}"
        },
        birthday_year: {
            required: "{AccountIntl::$validation_birthday_year_required|escape}",
            number: "{AccountIntl::$validation_birthday_year_not_valid|escape}",
            maxlength: "{AccountIntl::$validation_birthday_year_not_valid|escape}",
            range: "{AccountIntl::$validation_birthday_year_not_valid|escape}"
        },
        gender: {
          required: "{AccountIntl::$validation_gender_required|escape}"
        },
        mobile_phone: {
            required: "{AccountIntl::$validation_mobile_phone_required|escape}",
            rangelength: "{AccountIntl::$validation_mobile_phone_length_range|escape|replace:"\n":"<br />"}",
            pattern: "{AccountIntl::$validation_mobile_phone_regexp|escape}"
        },
        email: {
          required: "{AccountIntl::$validation_email_required|escape}",
          email: "{AccountIntl::$validation_email_invalid|escape}",
          maxlength: "{AccountIntl::$validation_email_length|escape}"
        },
        location_iso2: {
            required: "{AccountIntl::$validation_location_required|escape}"
        },
        timezone_area: {
            required: ""
        },
        timezone_value: {
            required: "{AccountIntl::$validation_timezone_required|escape}"
        }
      },
      errorPlacement: function(error, element) {
          element.parent().append(error);
      },
      success: function(label) {
        if(label.attr('for')=='profile_first_name'){
          if(jQuery('#profile_last_name').hasClass('valid')){
            jQuery('#profile_first_name').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='profile_last_name'){
          if(jQuery('#profile_first_name').hasClass('valid')){
            jQuery('#profile_last_name').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='profile_birthday_day'){
          if(jQuery('#profile_birthday_year').hasClass('valid')){
            jQuery('#profile_birthday_day').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='profile_birthday_month'){
          if(jQuery('#profile_birthday_day').hasClass('valid') && jQuery('#profile_birthday_year').hasClass('valid')){
            jQuery('#profile_birthday_month').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='profile_birthday_year'){
          if(jQuery('#profile_birthday_day').hasClass('valid')){
            jQuery('#profile_birthday_year').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        if(label.attr('for')=='profile_timezone_area'){
          if(jQuery('#profile_timezone_value').valid()){
            jQuery('#profile_timezone_area').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='profile_timezone_value'){
          if(jQuery('#profile_timezone_value').hasClass('valid')){
            jQuery('#profile_timezone_area').removeClass('error');
            jQuery('#profile_timezone_value').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else{
          jQuery('#'+label.attr('for')).closest('.control-group').removeClass('error').addClass('success');
        }
        label.remove();
      },
      highlight: function(element, errorClass, validClass) {
        if (element.type == 'radio') {
          this.findByName(element.name).addClass(errorClass).removeClass(validClass);
        } else {
          jQuery(element).addClass(errorClass).removeClass(validClass);
        }
        jQuery(element).closest('.control-group').removeClass('success').addClass('error');
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    jQuery('#account_profile_form :input').on('change', function(){
      jQuery(this).valid();
    });

    bindPhoneFieldEvents('#profile_mobile_phone', '#profile_mobile_phone_location_iso2', '#profile_mobile_phone_location_iso2_flag', locationList, defaultLocationCode);

    {if !empty($profile_errors)}

    jQuery('#account_profile_form :input').valid();

    jQuery.each({$profile_errors|json_encode}, function(field, message){

      var fieldId = 'profile_'+field;

      jQuery('#'+fieldId).parent().find('label[for='+fieldId+']').remove();
      jQuery('#'+fieldId).closest('.control-group').removeClass('success').addClass('error');
      jQuery('#'+fieldId).parent().append(jQuery('<label>').attr('for', fieldId).attr('class', 'error').html(message));
    });
    {/if}

    jQuery('#profile_timezone_area').on('change', function(){

      var timezones = {TimeZoneList::$items|json_encode};

      jQuery('#profile_timezone_value option:gt(0)').remove();

      if(this.value!=''){

        jQuery.each(timezones[this.value], function(i, item){
          jQuery('#profile_timezone_value').append($('<option></option>').attr("value", item).text(item));
        });
      }

    });
  });
  </script>
  <form id="account_profile_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <fieldset>
      <div class="control-group">
        <label for="profile_nickname" class="control-label">Your nickname</label>
        <div class="controls">
          <input type="text" id="profile_nickname" name="nickname" value="{$profile.nickname|default:''|escape}" class="input-large">
        </div>
      </div>
      <div class="control-group">
        <label for="profile_first_name" class="control-label">Real name</label>
        <div class="controls">
          <input type="text" id="profile_first_name" name="first_name" value="{$profile.first_name|default:''|escape}" placeholder="First" class="input-small valid">
          <input type="text" id="profile_last_name" name="last_name" value="{$profile.last_name|default:''|escape}" placeholder="Last" class="input-small valid">
        </div>
      </div>
      <div class="control-group">
        <label for="profile_birthday_day" class="control-label">Birthday</label>
        <div class="controls">
          <input type="text" id="profile_birthday_day" name="birthday_day" value="{$profile.birthday_day|default:''|escape}" placeholder="day" class="input-mini valid">
          {assign var=months value=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')}
          <select id="profile_birthday_month" name="birthday_month" class="input-small valid">
            {foreach from=$months key=key item=month_name}
            <option value="{$key+1}"{if $profile.birthday_month|default:''==$key+1} selected="selected"{/if}>{$month_name}</option>
            {/foreach}
          </select>
          <input type="text" id="profile_birthday_year" name="birthday_year" value="{$profile.birthday_year|default:''|escape}" placeholder="year" class="input-mini valid">
        </div>
      </div>
      <div class="control-group">
        <label for="profile_gender" class="control-label">Gender</label>
        <div class="controls">
          <select id="profile_gender" name="gender" class="input-medium">
            <option value=""></option>
            <option value="Male"{if $profile.gender|default:''=='Male'} selected="selected"{/if}>Male</option>
            <option value="Female"{if $profile.gender|default:''=='Female'} selected="selected"{/if}>Female</option>
            <option value="Other"{if $profile.gender|default:''=='Other'} selected="selected"{/if}>Other</option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label for="profile_mobile_phone" class="control-label">Mobile phone</label>
        <div class="controls">
          <div class="pull-left" style="width: 0; overflow: hidden;">
            <input type="text" id="profile_mobile_phone_location_iso2" name="mobile_phone_location_iso2" value="" tabindex="-1">
          </div>
          <div class="input-prepend">
            <div id="profile_mobile_phone_location_iso2_flag" class="add-on btn pull-left"><i class="icon-location-flag"></i></div>
            <input type="text" id="profile_mobile_phone" name="mobile_phone" value="{$profile.mobile_phone|default:''|escape}" class="input-large pull-left">
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="control-group">
        <label for="profile_email" class="control-label">Your email address</label>
        <div class="controls">
          <input type="text" id="profile_email" name="email" value="{$profile.email|default:''|escape}" class="input-large">
        </div>
      </div>
      <div class="control-group">
        <label for="profile_location_iso2" class="control-label">Location</label>
        <div class="controls">
          <select id="profile_location_iso2" name="location_iso2" class="input-large">
            <option value=""></option>
            {foreach key=key item=item from=CountryList::getItems(true, 'us')}
              <option value="{$key}"{if $profile.location_iso2|default:''==$key} selected="selected"{/if}>{$item.name|escape}{if $item.local} ({$item.local|escape}){/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="control-group">
        <label for="profile_timezone_area" class="control-label">Timezone</label>
        <div class="controls">
          <select id="profile_timezone_area" name="timezone_area" class="input-small">
            <option value=""></option>
            {foreach key=key item=item from=TimeZoneList::$items}
              <option value="{$key}"{if $profile.timezone_area|default:''==$key} selected="selected"{/if}>{$key}</option>
            {/foreach}
          </select>
          <select id="profile_timezone_value" name="timezone_value" class="input-medium">
            <option value=""></option>
            {foreach key=key item=item from=TimeZoneList::$items[$profile.timezone_area]}
              <option value="{$item}"{if ($profile.timezone=="`$profile.timezone_area`/`$item`") || ($profile.timezone_area=='Other' && $profile.timezone==$item)} selected="selected"{/if}>{$item}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-actions">
        <input type="submit" name="update_profile" value="Update profile" class="btn btn-primary btn-large" />
      </div>
    </fieldset>
  </form>
</div>
