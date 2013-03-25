<div class="controller account-activation well">

  <div class="page-header">
    <h2>Account activation required</h2>
  </div>
  <script type="text/javascript">

  jQuery(function(){

    jQuery('#account_activation_form').validate({
      rules: {
        username: {
          required: true
        },
        activation_code: {
          required: true
        }
      },
      messages: {
        username: {
          required: "{AccountIntl::$validation_username_required}"
        },
        activation_code: {
          required: "{AccountIntl::$validation_activation_code_required}"
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


    jQuery('#account_activation_form :input').on('change', function(){
      jQuery(this).valid();
    });

    {if !empty($activation_errors)}

    jQuery('#account_activation_form :input').valid();

    jQuery.each({$activation_errors|json_encode}, function(field, message){

      var fieldId = 'reg_'+field;

      jQuery('#'+fieldId).parent().find('label[for='+fieldId+']').remove();
      jQuery('#'+fieldId).closest('.control-group').removeClass('success').addClass('error');
      jQuery('#'+fieldId).parent().append(jQuery('<label>').attr('for', fieldId).attr('class', 'error').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_activation_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <fieldset>
      <div class="control-group">
        <label for="reg_username" class="control-label">Your username</label>
        <div class="controls">
          <input type="text" id="reg_username" name="username" value="{$username|escape}" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="control-group">
        <label for="reg_activation_code" class="control-label">Activation code</label>
        <div class="controls">
          <input type="text" id="reg_activation_code" name="activation_code" value="{$activation_code|default:''|escape}" class="input-large" autocomplete="off">
        </div>
      </div>
      <div class="form-actions">
        <input type="submit" name="activate" value="Activate account" class="btn btn-primary btn-large" />
      </div>
    </fieldset>


  </form>
</div>
