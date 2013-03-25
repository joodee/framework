<div class="controller account-password-change well">

  <div class="page-header">
    <h2>Change your password</h2>
  </div>
  <script type="text/javascript">

  jQuery(function(){

    jQuery('#account_change_password_form').validate({
      rules: {
        password_current: {
          required: true
        },
        password_new: {
          required: true,
          minlength: 8,
          maxlength: 32
        },
        password_new_confirm: {
          required: true,
          equalTo: '#change_password_new'
        }
      },
      messages: {
        password_current: {
          required: "{AccountIntl::$validation_password_required}"
        },
        password_new: {
          required: "{AccountIntl::$validation_new_password_required}",
          minlength: "{AccountIntl::$validation_password_length_min}",
          maxlength: "{AccountIntl::$validation_password_length_max}"
        },
        password_new_confirm: {
          required: "{AccountIntl::$validation_new_password_confirmation_required}",
          equalTo: "{AccountIntl::$validation_passwords_dont_match}"
        }
      },
      errorPlacement: function(error, element) {
        element.parent().append(error);
      },
      success: function(label) {
        jQuery('#'+label.attr('for')).closest('.control-group').removeClass('error').addClass('success');
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


    jQuery('#account_change_password_form :input').on('change', function(){
      jQuery(this).valid();
    });

    {if !empty($change_password_errors)}

    {*jQuery('#account_change_password_form :input').valid();*}

    jQuery.each({$change_password_errors|json_encode}, function(fieldName, message){

      var field = jQuery('#account_change_password_form :input[name='+fieldName+']');

      field.parent().find('label[for='+field.attr('id')+']').remove();
      field.closest('.control-group').removeClass('success').addClass('error');
      field.parent().append(jQuery('<label>').attr('for', field.attr('id')).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_change_password_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <fieldset>
      <div class="control-group">
        <label for="change_password_current" class="control-label">Current password</label>
        <div class="controls">
          <input type="password" id="change_password_current" name="password_current" value="" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label for="change_password_new" class="control-label">New password</label>
        <div class="controls">
          <input type="password" id="change_password_new" name="password_new" value="" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label for="change_password_new_confirm" class="control-label">Retype new password</label>
        <div class="controls">
          <input type="password" id="change_password_new_confirm" name="password_new_confirm" value="" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="form-actions">
        <input type="submit" name="change_password" value="Change password" class="btn btn-primary btn-large" />
      </div>
    </fieldset>
  </form>
</div>
