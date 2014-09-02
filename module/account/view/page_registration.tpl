<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Sign Up <small>for Account</small></h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li class="active">Registration</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row account-registration">
  <div class="col-md-8">
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
        birthday: {
            required: true,
            date:true
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
        birthday: {
            required: "{AccountIntl::$validation_birthday_date_required|escape}",
            date: "{AccountIntl::$validation_birthday_date_not_valid|escape}"
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
        jQuery(element).closest('.form-group').find('.error-block').remove();
        jQuery(element).closest('.form-group').find('div:first').append(jQuery(error).addClass('help-block'));
      },
      highlight: function(element) {
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

      jQuery('#'+fieldId+'-error').remove();
      jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
      jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_registration_form" action="{$__route.uri}" method="post" class="form-horizontal" role="form">
    <fieldset>
      <div class="form-group">
        <label for="reg_first_name" class="col-md-4 control-label">What is your first name?</label>
        <div class="col-md-6">
          <input type="text" id="reg_first_name" name="first_name" value="{$smarty.post.first_name|default:''|escape}" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="reg_last_name" class="col-md-4 control-label">Last name</label>
        <div class="col-md-6">
          <input type="text" id="reg_last_name" name="last_name" value="{$smarty.post.last_name|default:''|escape}" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="reg_username" class="col-md-4 control-label">Choose your username</label>
        <div class="col-md-6">
          <input type="text" id="reg_username" name="username" value="{$smarty.post.username|default:''|escape}" autocomplete="off" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label for="reg_password" class="col-md-4 control-label">Create a password</label>
        <div class="col-md-6">
          <input id="reg_password" type="password" name="password" value="{$smarty.post.password|default:''|escape}" autocomplete="off" class="form-control" />
        </div>
      </div>
      <div class="form-group">
        <label for="reg_confirm_password" class="col-md-4 control-label">Confirm your password</label>
        <div class="col-md-6">
          <input id="reg_confirm_password" type="password" name="confirm_password" value="{$smarty.post.confirm_password|default:''|escape}" autocomplete="off" class="form-control" />
        </div>
      </div>
      <div class="form-group">
        <label for="reg_birthday" class="col-md-4 control-label">Birthday</label>
        <div class="col-md-6">
          <div class="input-group">
            <span class="btn btn-default input-group-addon" onclick="$('#reg_birthday').focus();"><i class="glyphicon glyphicon-calendar"></i></span>
            <input type="text" id="reg_birthday" name="birthday" value="{$smarty.post.birthday|default:''|escape}" placeholder="YYYY-MM-DD" class="form-control autodatepicker" data-date-viewmode="years">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="reg_gender" class="col-md-4 control-label">Gender</label>
        <div class="col-md-6">
          <select id="reg_gender" name="gender" class="form-control">
            <option value=""></option>
            <option value="Male"{if $smarty.post.gender|default:''=='Male'} selected="selected"{/if}>Male</option>
            <option value="Female"{if $smarty.post.gender|default:''=='Female'} selected="selected"{/if}>Female</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="reg_mobile_phone" class="col-md-4 control-label">Mobile phone</label>
        <div class="col-md-6">
          <div class="pull-left" style="width: 0; overflow: hidden;">
            <input type="text" id="reg_mobile_phone_location_iso2" name="mobile_phone_location_iso2" value="" tabindex="-1" class="form-control">
          </div>
          <div class="input-group">
            <span id="reg_mobile_phone_location_iso2_flag" class="btn input-group-addon"><i class="icon-location-flag"></i></span>
            <input type="text" id="reg_mobile_phone" name="mobile_phone" value="{$smarty.post.mobile_phone|default:''|escape}" class="form-control clearfix">
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="form-group">
        <label for="reg_email" class="col-md-4 control-label">Your email address</label>
        <div class="col-md-6">
          <input type="text" id="reg_email" name="email" value="{$smarty.post.email|default:''|escape}" class="form-control">
        </div>
      </div>
      {CaptchaController::fetch('registration', 'account', 'captcha_registration.tpl')}
      <div class="form-group">
        <label for="reg_location_iso2" class="col-md-4 control-label">Location</label>
        <div class="col-md-6">
          <select id="reg_location_iso2" name="location_iso2" class="form-control">
            <option value=""></option>
            {foreach key=key item=item from=CountryList::getItems(true, 'us')}
              <option value="{$key}"{if $smarty.post.location_iso2|default:''==$key} selected="selected"{/if}>{$item.name|escape}{if $item.local} ({$item.local|escape}){/if}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">&nbsp;</label>
        <div class="col-md-6">
          <label class="checkbox terms-and-privacy"><input type="checkbox" id="reg_i_agree" name="i_agree" value="1" class="pull-left"{if $smarty.post.i_agree|default:''==1} checked="checked" {/if} />
          I agree to the <a target="_blank" href="/terms-of-service/">Terms of Service</a> and <a target="_blank" href="/privacy-policy/">Privacy Policy</a></label>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="form-group">
        <label class="col-md-4 control-label">&nbsp;</label>
        <div class="col-md-6">
          <button type="submit" name="create_account" class="btn btn-primary btn-lg">Create account</button>
        </div>
      </div>
    </fieldset>
  </form>
  </div>

  {widgets area="sidebar_right"}

</div>

