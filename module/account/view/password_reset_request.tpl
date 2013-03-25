<div class="controller account-password-reset-request well">

  <div class="page-header">
    <h2>Reset password tool</h2>
  </div>
  {if Helper::isPost() && empty($reset_errors)}
    <div class="alert alert-success">
      <div class="alert-error-decoration"></div>
      <h3>Reset password instructions were sent to your email address.</h3>
      If you don't receive instructions within few minutes, check your email's spam and junk filters, or try <a href="{$__route.uri}">resending your request</a>.
    </div>
  {else}
  <script type="text/javascript">

  jQuery(function(){

    jQuery('#account_reset_form').validate({
      rules: {
        username: {
          required: true
        },
        captcha_code: {
          required: true
        }
      },
      messages: {
        username: {
          required: "{AccountIntl::$validation_username_or_email_required}"
        },
        captcha_code: {
          required: "{AccountIntl::$validation_captcha_required}"
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

    {*jQuery('#account_reset_form :input').valid();*}

    jQuery.each({$reset_errors|json_encode}, function(fieldName, message){

      var field = jQuery('#account_reset_form :input[name='+fieldName+']');

      field.parent().find('label[for='+field.attr('id')+']').remove();
      field.closest('.control-group').removeClass('success').addClass('error');
      field.parent().append(jQuery('<label>').attr('for', field.attr('id')).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_reset_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <div class="alert alert-info">
      <div class="alert-error-decoration"></div>
      Enter the information below and we'll send you an email with the next steps to get a new password.
    </div>

    <fieldset>
      <div class="control-group">
        <label for="reset_username" class="control-label">Your username or email</label>
        <div class="controls">
          <input type="text" id="reset_username" name="username" value="{$smarty.post.username|default:''|escape}" class="input-large" autocomplete="off">
        </div>
      </div>
      {CaptchaController::fetch('reset_password')}

      <div class="form-actions">
        <input type="submit" name="reset_password" value="Submit" class="btn btn-primary btn-large" />
      </div>
    </fieldset>
  </form>
  {/if}
</div>
