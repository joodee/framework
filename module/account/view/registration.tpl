<div class="controller account-registration well">

  <div class="page-header">
    <h2>Create an account</h2>
  </div>
  <script type="text/javascript">

  var locationList = {CountryList::getItems(true, 'us')|json_encode};
  var defaultLocationCode = '{CountryList::getRemoteLocationCode('us')}';

  jQuery(function(){

    jQuery('#account_registration_form').validate({
      rules: {
        first_name: {
          required:true,
          maxlength: 32
        },
        last_name: {
          required: true,
          maxlength: 32
        },
        username: {
          required: true,
          minlength: 4,
          maxlength: 24,
          pattern: {$__config.environment.module.account.username_regexp},
          remote: {
            url: '{$__route.uri}check/',
            type: 'post'
          }
        },
        password: {
          required: true,
          minlength: 8,
          maxlength: 32
        },
        confirm_password: {
          required: true,
          equalTo: '#reg_password'
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
          maxlength: 64,
          remote: {
            url: '{$__route.uri}check/',
            type: 'post'
          }
        },
        captcha_code: {
            required: true
        },
        location_iso2: {
            required: true
        },
        i_agree: {
            required: true
        }
      },
      messages: {
        first_name: {
          required: "{AccountIntl::$validation_first_name_required|escape}",
          maxlength: "{AccountIntl::$validation_first_name_length_max|escape}"
        },
        last_name: {
          required: "{AccountIntl::$validation_last_name_required|escape}",
          maxlength: "{AccountIntl::$validation_last_name_length_max|escape}"
        },
        username: {
          required: "{AccountIntl::$validation_username_required|escape}",
          length_min: "{AccountIntl::$validation_username_length_min|escape}",
          length_max: "{AccountIntl::$validation_username_length_max|escape}",
          pattern: "{AccountIntl::$validation_username_regexp|escape}",
          remote: "{AccountIntl::$validation_username_taken|escape}"
        },
        password: {
          required: "{AccountIntl::$validation_password_required|escape}",
          minlength: "{AccountIntl::$validation_password_length_min|escape}",
          maxlength: "{AccountIntl::$validation_password_length_max|escape}"
        },
        confirm_password: {
          required: "{AccountIntl::$validation_confirm_password_required|escape}",
          equalTo: "{AccountIntl::$validation_passwords_dont_match|escape}"
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
          maxlength: "{AccountIntl::$validation_email_length|escape}",
          remote: "{AccountIntl::$validation_email_taken|escape|replace:"\n":"<br />"}"
        },
        captcha_code: {
            required: "{AccountIntl::$validation_captcha_required|escape}"
        },
        location_iso2: {
            required: "{AccountIntl::$validation_location_required|escape}"
        },
        i_agree: {
            required: "{AccountIntl::$validation_tos_and_pp_agree_required|escape}"
        }
      },
      errorPlacement: function(error, element) {
        element.parent().append(error);
      },
      success: function(label) {
        if(label.attr('for')=='reg_first_name'){
          if(jQuery('#reg_last_name').hasClass('valid')){
            jQuery('#reg_first_name').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='reg_last_name'){
          if(jQuery('#reg_first_name').hasClass('valid')){
            jQuery('#reg_last_name').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='reg_birthday_day'){
          if(jQuery('#reg_birthday_year').hasClass('valid')){
            jQuery('#reg_birthday_day').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='reg_birthday_month'){
          if(jQuery('#reg_birthday_day').hasClass('valid') && jQuery('#reg_birthday_year').hasClass('valid')){
            jQuery('#reg_birthday_month').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='reg_birthday_year'){
          if(jQuery('#reg_birthday_day').hasClass('valid')){
            jQuery('#reg_birthday_year').closest('.control-group').removeClass('error').addClass('success');
          }
        }
        else if(label.attr('for')=='i_agree'){
          jQuery('#reg_i_agree').closest('.control-group').removeClass('error').addClass('success');
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
        document.cookie = "TestCookie=1; path=/; domain=." + window.location.hostname;
        form.submit();
      }
    });

    jQuery('#account_registration_form :input').on('change', function(){
      jQuery(this).valid();
    });

    bindPhoneFieldEvents('#reg_mobile_phone', '#reg_mobile_phone_location_iso2', '#reg_mobile_phone_location_iso2_flag', locationList, defaultLocationCode);

    {if !empty($registration_errors)}

    jQuery('#account_registration_form :input').valid();

    jQuery.each({$registration_errors|json_encode}, function(field, message){

      if(field=='captcha_code'){
        var fieldId = 'captcha_code_registration';
      }
      else{
        var fieldId = 'reg_'+field;
      }
      jQuery('#'+fieldId).parent().find('label[for='+fieldId+']').remove();
      jQuery('#'+fieldId).closest('.control-group').removeClass('success').addClass('error');
      jQuery('#'+fieldId).parent().append(jQuery('<label>').attr('for', fieldId).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_registration_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <fieldset>
      <div class="control-group">
        <label for="reg_first_name" class="control-label">What is your name?</label>
        <div class="controls">
          <input type="text" id="reg_first_name" name="first_name" value="{$smarty.post.first_name|default:''|escape}" placeholder="First" class="input-small">
          <input type="text" id="reg_last_name" name="last_name" value="{$smarty.post.last_name|default:''|escape}" placeholder="Last" class="input-small">
        </div>
      </div>
      <div class="control-group">
        <label for="reg_username" class="control-label">Choose your username</label>
        <div class="controls">
          <input type="text" id="reg_username" name="username" value="{$smarty.post.username|default:''|escape}" autocomplete="off" class="input-large">
        </div>
      </div>
      <div class="control-group">
        <label for="reg_password" class="control-label">Create a password</label>
        <div class="controls">
          <input id="reg_password" type="password" name="password" value="{$smarty.post.password|default:''|escape}" autocomplete="off" class="input-large" />
        </div>
      </div>
      <div class="control-group">
        <label for="reg_confirm_password" class="control-label">Confirm your password</label>
        <div class="controls">
          <input id="reg_confirm_password" type="password" name="confirm_password" value="{$smarty.post.confirm_password|default:''|escape}" autocomplete="off" class="input-large" />
        </div>
      </div>
      <div class="control-group">
        <label for="reg_birthday_day" class="control-label">Birthday</label>
        <div class="controls">
          <input type="text" id="reg_birthday_day" name="birthday_day" value="{$smarty.post.birthday_day|default:''|escape}" placeholder="day" class="input-mini">
          {assign var=months value=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')}
          <select id="reg_birthday_month" name="birthday_month" class="input-small">
            {foreach from=$months key=key item=month_name}
            <option value="{$key+1}"{if $smarty.post.birthday_month|default:''==$key+1} selected="selected"{/if}>{$month_name}</option>
            {/foreach}
          </select>
          <input type="text" id="reg_birthday_year" name="birthday_year" value="{$smarty.post.birthday_year|default:''|escape}" placeholder="year" class="input-mini">
        </div>
      </div>
      <div class="control-group">
        <label for="reg_gender" class="control-label">Gender</label>
        <div class="controls">
          <select id="reg_gender" name="gender" class="input-medium">
            <option value=""></option>
            <option value="Male"{if $smarty.post.gender|default:''=='Male'} selected="selected"{/if}>Male</option>
            <option value="Female"{if $smarty.post.gender|default:''=='Female'} selected="selected"{/if}>Female</option>
            <option value="Other"{if $smarty.post.gender|default:''=='Other'} selected="selected"{/if}>Other</option>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label for="reg_mobile_phone" class="control-label">Mobile phone</label>
        <div class="controls">
          <div class="pull-left" style="width: 0; overflow: hidden;">
            <input type="text" id="reg_mobile_phone_location_iso2" name="mobile_phone_location_iso2" value="" tabindex="-1">
          </div>
          <div class="input-prepend">
            <div id="reg_mobile_phone_location_iso2_flag" class="add-on btn pull-left"><i class="icon-location-flag"></i></div>
            <input type="text" id="reg_mobile_phone" name="mobile_phone" value="{$smarty.post.mobile_phone|default:''|escape}" class="input-large pull-left">
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="control-group">
        <label for="reg_email" class="control-label">Your email address</label>
        <div class="controls">
          <input type="text" id="reg_email" name="email" value="{$smarty.post.email|default:''|escape}" class="input-large">
        </div>
      </div>
      {CaptchaController::fetch('registration', 'account', 'registration_captcha.tpl')}
      <div class="control-group">
        <label for="reg_location_iso2" class="control-label">Location</label>
        <div class="controls">
          <select id="reg_location_iso2" name="location_iso2" class="input-large">
            <option value=""></option>
            {foreach key=key item=item from=CountryList::getItems(true, 'us')}
              <option value="{$key}"{if $smarty.post.location_iso2|default:''==$key} selected="selected"{/if}>{$item.name|escape}{if $item.local} ({$item.local|escape}){/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label">&nbsp;</label>
        <div class="controls">
          <label class="checkbox terms-and-privacy"><input type="checkbox" id="reg_i_agree" name="i_agree" value="1" class="pull-left"{if $smarty.post.i_agree|default:''==1} checked="checked" {/if} />
          I agree to the <a target="_blank" href="/terms-of-service/">Terms of Service</a> and <a target="_blank" href="/privacy-policy/">Privacy Policy</a></label>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="form-actions">
        <input type="submit" name="create_account" value="Create account" class="btn btn-primary btn-large" />
      </div>
    </fieldset>


  </form>
</div>
