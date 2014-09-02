<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Reset password tool <small>Set new password</small></h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/login/">Authentication</a></li>
      <li><a href="/forgot/">Recovery</a></li>
      <li><a href="/reset_password/">Reset password</a></li>
      <li class="active">New password</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row account-password-reset-form">
  <div class="col-md-8">
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
          document.cookie = "TestCookie=1; path=/; domain=." + window.location.hostname;
          form.submit();
        },
        errorElement: 'span',
        errorClass: 'error-block'
      });


      jQuery('#account_reset_form :input').on('change', function(){
        jQuery(this).valid();
      });

      {if !empty($reset_errors)}

      jQuery.each({$reset_errors|json_encode}, function(field, message){

        var fieldId = 'reset_'+field;

        jQuery('#'+fieldId+'-error').remove();
        jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
        jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
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
        <div class="form-group">
          <label for="reset_password" class="col-md-4 control-label">New password</label>
          <div class="col-md-6">
            <input type="password" id="reset_password" name="password" value="" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="reset_confirm_password" class="col-md-4 control-label">Confirm password</label>
          <div class="col-md-6">
            <input type="password" id="reset_confirm_password" name="confirm_password" value="" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label">&nbsp;</label>
          <div class="col-md-6">
            <input type="submit" name="reset_password" value="Reset password" class="btn btn-primary btn-lg" />
          </div>
        </div>
      </fieldset>
    </form>
  </div>

  {widgets area="sidebar_right"}

</div>
