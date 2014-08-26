<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Account activation required</h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/registration/">Registration</a></li>
      <li class="active">Account activation</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>
<div class="row account-activation">
  <div class="col-md-8">

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
        jQuery(element).closest('.form-group').find('.error-block').remove();
        jQuery(element).closest('.form-group').find('div:first').append(jQuery(error).addClass('help-block'));
      },
      highlight: function(element) {
        jQuery(element).closest('.form-group').addClass('has-error');
      },
      unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error').find('.error-block').remove();
      },
      submitHandler: function(form) {
        document.cookie = "TestCookie=1; path=/; domain=." + window.location.hostname;
        form.submit();
      },
      errorElement: 'span',
      errorClass: 'error-block'
    });


    jQuery('#account_activation_form :input').on('change', function(){
      jQuery(this).valid();
    });

    {if !empty($activation_errors)}

    jQuery('#account_activation_form :input').valid();

    jQuery.each({$activation_errors|json_encode}, function(field, message){

      var fieldId = 'reg_'+field;

      jQuery('#'+fieldId+'-error').remove();
      jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
      jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
    });
    {/if}
  });
  </script>
  <form id="account_activation_form" action="{$__route.uri}" method="post" class="form-horizontal">
    <fieldset>
      <div class="form-group">
        <label for="reg_username" class="col-md-3 control-label">Your username</label>
        <div class="col-md-6">
          <input type="text" id="reg_username" name="username" value="{$username|escape}" class="form-control" autocomplete="off">
        </div>
      </div>
      <div class="form-group">
        <label for="reg_activation_code" class="col-md-3 control-label">Activation code</label>
        <div class="col-md-6">
          <input type="text" id="reg_activation_code" name="activation_code" value="{$activation_code|default:''|escape}" class="form-control" autocomplete="off">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-6">
          <input type="submit" name="activate" value="Activate account" class="btn btn-primary btn-lg" />
        </div>
      </div>
    </fieldset>
  </form>
</div>
{widgets area="sidebar_right"}
</div>
