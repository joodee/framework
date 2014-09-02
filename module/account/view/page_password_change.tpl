<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Change Password <small>Private Area</small></h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/account/">My Account</a></li>
      <li class="active">Change Password</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row account-password-change">
  <div class="col-md-8">
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


      jQuery('#account_change_password_form :input').on('change', function(){
        jQuery(this).valid();
      });

      {if !empty($change_password_errors)}

      {*jQuery('#account_change_password_form :input').valid();*}

      jQuery.each({$change_password_errors|json_encode}, function(field, message){

        var fieldId = 'change_'+field;

        jQuery('#'+fieldId+'-error').remove();
        jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
        jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
      });
      {/if}
    });
    </script>
    <form id="account_change_password_form" action="{$__route.uri}" method="post" class="form-horizontal">
      <fieldset>
        <div class="form-group">
          <label for="change_password_current" class="col-md-4 control-label">Current password</label>
          <div class="col-md-6">
            <input type="password" id="change_password_current" name="password_current" value="" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="change_password_new" class="col-md-4 control-label">New password</label>
          <div class="col-md-6">
            <input type="password" id="change_password_new" name="password_new" value="" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="form-group">
          <label for="change_password_new_confirm" class="col-md-4 control-label">Retype new password</label>
          <div class="col-md-6">
            <input type="password" id="change_password_new_confirm" name="password_new_confirm" value="" class="form-control" autocomplete="off">
          </div>
        </div>
        <div class="form-group" style="margin-top: 30px;">
          <label class="col-md-4 control-label">&nbsp;</label>
          <div class="col-md-6">
            <button type="submit" name="change_password" class="btn btn-primary">Change password</button>
          </div>
        </div>
      </fieldset>
    </form>
  </div>

  {widgets area="sidebar_right"}

</div>
