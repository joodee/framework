<div class="controller account-password-reset-form well">

  <div class="page-header">
    <h2>Reset password tool</h2>
  </div>
  <script type="text/javascript">

  jQuery(function(){

    jQuery('#account_reset_form').validate({
      rules: {
        password: {
          required: true,
          minlength: 8,
          maxlength: 32
        },
        confirm_password: {
          required: true,
          equalTo: '#reset_password'
        }
      },
      messages: {
        password: {
          required: "{AccountIntl::$validation_new_password_required}",
          minlength: "{AccountIntl::$validation_password_length_min}",
          maxlength: "{AccountIntl::$validation_password_length_max}"
        },
        confirm_password: {
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


    jQuery('#account_reset_form :input').on('change', function(){
      jQuery(this).valid();
    });

    {if !empty($reset_errors)}

    jQuery.each({$reset_errors|json_encode}, function(fieldName, message){

      var field = jQuery('#account_reset_form :input[name='+fieldName+']');

      field.parent().find('label[for='+field.attr('id')+']').remove();
      field.closest('.control-group').removeClass('success').addClass('error');
      field.parent().append(jQuery('<label>').attr('for', field.attr('id')).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_reset_form" action="" method="post" class="form-horizontal">
    <div class="alert alert-info">
      <div class="alert-error-decoration"></div>
      Now you can change your password using the form below.
    </div>

    <fieldset>
      <div class="control-group">
        <label for="reset_password" class="control-label">New password</label>
        <div class="controls">
          <input type="password" id="reset_password" name="password" value="" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label for="reset_confirm_password" class="control-label">Confirm password</label>
        <div class="controls">
          <input type="password" id="reset_confirm_password" name="confirm_password" value="" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="form-actions">
        <input type="submit" name="reset_password" value="Reset password" class="btn btn-primary btn-large" />
      </div>
    </fieldset>
  </form>

</div>
