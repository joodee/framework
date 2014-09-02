<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">My Profile <small>Private Area</small></h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/account/">My Account</a></li>
      <li class="active">Edit Profile</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="account-profile">

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
            birthday: {
                required: true,
                date: true
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
            timezone_value: {
                required: true
            }
          },
          messages: {
            nickname: {
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
              maxlength: "{AccountIntl::$validation_email_length|escape}"
            },
            location_iso2: {
                required: "{AccountIntl::$validation_location_required|escape}"
            },
            timezone_value: {
                required: "{AccountIntl::$validation_timezone_required|escape}"
            }
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
            form.submit();
          },
          errorElement: 'span',
          errorClass: 'error-block'
        });

        jQuery('#account_profile_form :input').on('change', function(){
          jQuery(this).valid();
        });

        bindPhoneFieldEvents('#profile_mobile_phone', '#profile_mobile_phone_location_iso2', '#profile_mobile_phone_location_iso2_flag', locationList, defaultLocationCode);

        {if !empty($profile_errors)}

        jQuery('#account_profile_form :input').valid();

        jQuery.each({$profile_errors|json_encode}, function(field, message){

          var fieldId = 'profile_'+field;

          jQuery('#'+fieldId+'-error').remove();
          jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
          jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
        });
        {/if}

        jQuery('#profile_timezone_area').on('change', function(){

          var timezones = {TimeZoneList::$items|json_encode};

          jQuery('#profile_timezone_value option:gt(0)').remove();

          if(this.value!=''){

            jQuery.each(timezones[this.value], function(i, item){
              jQuery('#profile_timezone_value').append($('<option></option>').attr("value", item).text(item));
            });
            jQuery('#profile_timezone_value').focus();
          }
          jQuery('#profile_timezone_value').valid();
        });
      });
      </script>
      <form id="account_profile_form" action="{$__route.uri}" method="post" class="form-horizontal">
        <fieldset>
          <div class="form-group">
            <label for="profile_nickname" class="col-md-3 control-label">Your nickname</label>
            <div class="col-md-6">
              <input type="text" id="profile_nickname" name="nickname" value="{$profile.nickname|default:''|escape}" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="profile_first_name" class="col-md-3 control-label">First name</label>
            <div class="col-md-6">
              <input type="text" id="profile_first_name" name="first_name" value="{$profile.first_name|default:''|escape}" class="form-control valid">
            </div>
          </div>
          <div class="form-group">
            <label for="profile_last_name" class="col-md-3 control-label">Last name</label>
            <div class="col-md-6">
              <input type="text" id="profile_last_name" name="last_name" value="{$profile.last_name|default:''|escape}" class="form-control valid">
            </div>
          </div>
          <div class="form-group">
            <label for="profile_birthday" class="col-md-3 control-label">Birthday</label>
            <div class="col-md-6">
              <div class="input-group">
                <span class="btn btn-default input-group-addon" onclick="$('#profile_birthday').focus();"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" id="profile_birthday" name="birthday" value="{$profile.birthday|default:''|escape}" placeholder="YYYY-MM-DD" class="form-control autodatepicker" data-date-viewmode="years">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="profile_gender" class="col-md-3 control-label">Gender</label>
            <div class="col-md-6">
              <select id="profile_gender" name="gender" class="form-control">
                <option value=""></option>
                <option value="Male"{if $profile.gender|default:''=='Male'} selected="selected"{/if}>Male</option>
                <option value="Female"{if $profile.gender|default:''=='Female'} selected="selected"{/if}>Female</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="profile_mobile_phone" class="col-md-3 control-label">Mobile phone</label>
            <div class="col-md-6">
              <div class="pull-left" style="width: 0; overflow: hidden;">
                <input type="text" id="profile_mobile_phone_location_iso2" name="mobile_phone_location_iso2" value="" tabindex="-1">
              </div>
              <div class="input-group">
                <div id="profile_mobile_phone_location_iso2_flag" class="btn input-group-addon"><i class="icon-location-flag"></i></div>
                <input type="text" id="profile_mobile_phone" name="mobile_phone" value="{$profile.mobile_phone|default:''|escape}" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="form-group">
            <label for="profile_email" class="col-md-3 control-label">Your email address</label>
            <div class="col-md-6">
              <input type="text" id="profile_email" name="email" value="{$profile.email|default:''|escape}" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="profile_location_iso2" class="col-md-3 control-label">Location</label>
            <div class="col-md-6">
              <select id="profile_location_iso2" name="location_iso2" class="form-control">
                <option value=""></option>
                {foreach key=key item=item from=CountryList::getItems(true, 'us')}
                  <option value="{$key}"{if $profile.location_iso2|default:''==$key} selected="selected"{/if}>{$item.name|escape}{if $item.local} ({$item.local|escape}){/if}</option>
                {/foreach}
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="profile_timezone_area" class="col-md-3 control-label">Timezone</label>
            <div class="col-md-6">
              <div class="input-group">
                <select id="profile_timezone_area" name="timezone_area" class="form-control">
                  <option value=""></option>
                  {foreach key=key item=item from=TimeZoneList::$items}
                    <option value="{$key}"{if $profile.timezone_area|default:''==$key} selected="selected"{/if}>{$key}</option>
                  {/foreach}
                </select>
                <select id="profile_timezone_value" name="timezone_value" class="form-control">
                  <option value=""></option>
                  {foreach key=key item=item from=TimeZoneList::$items[$profile.timezone_area]}
                    <option value="{$item}"{if ($profile.timezone=="`$profile.timezone_area`/`$item`") || ($profile.timezone_area=='Other' && $profile.timezone==$item)} selected="selected"{/if}>{$item}</option>
                  {/foreach}
                </select>
              </div>
            </div>
          </div>
          <div class="form-group" style="margin-top: 30px;">
            <label class="col-md-3 control-label">&nbsp;</label>
            <div class="col-md-6">
              <button type="submit" name="update_profile" class="btn btn-primary">Update profile</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>

  {widgets area="sidebar_right"}

</div>