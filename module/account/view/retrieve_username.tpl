<div class="controller account-retrieve-username well">

  <div class="page-header">
    <h2>Retrieve username tool</h2>
  </div>
  <script type="text/javascript">

  jQuery(function(){

    jQuery('#account_retrieve_form').validate({
      rules: {
        email: {
          required: true
        },
        captcha_code: {
          required: true
        }
      },
      messages: {
        email: {
          required: "{AccountIntl::$validation_email_required}"
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


    jQuery('#account_retrieve_form :input').on('change', function(){
      jQuery(this).valid();
    });

    {if !empty($retrieve_errors)}

    {*jQuery('#account_retrieve_form :input').valid();*}

    jQuery.each({$retrieve_errors|json_encode}, function(fieldName, message){

      var field = jQuery('#account_retrieve_form :input[name='+fieldName+']');

      field.parent().find('label[for='+field.attr('id')+']').remove();
      field.closest('.control-group').removeClass('success').addClass('error');
      field.parent().append(jQuery('<label>').attr('for', field.attr('id')).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_retrieve_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <div class="alert alert-info">
      <div class="alert-error-decoration"></div>
      If you forgot your username then enter email address specified in your account profile.
      <br />You will receive your username in an email.
    </div>

    <fieldset>
      <div class="control-group">
        <label for="retrieve_email" class="control-label">Your profile email</label>
        <div class="controls">
          <input type="text" id="retrieve_email" name="email" value="{$smarty.post.email|default:''|escape}" class="input-large" autocomplete="off">
        </div>
      </div>
      {CaptchaController::fetch('retrieve_username')}

      <div class="form-actions">
        <input type="submit" name="retrieve_username" value="Submit" class="btn btn-primary btn-large" />
      </div>
    </fieldset>
  </form>
</div>
