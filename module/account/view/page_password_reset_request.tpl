<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Reset password tool</h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/login/">Authentication</a></li>
      <li><a href="/forgot/">Recovery</a></li>
      <li class="active">Reset password</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row account-password-reset-request">
  <div class="col-md-8">
    {if Helper::isPost() && empty($reset_errors)}
      <div class="alert alert-success">
        <div class="alert-error-decoration"></div>
        <h3>Reset password instructions have been sent to your email address.</h3>
        If you don't receive instructions within a few minutes, check your email's spam and junk filters, or try <a href="{$__route.uri}">resending your request</a>.
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

      {*jQuery('#account_reset_form :input').valid();*}

      jQuery.each({$reset_errors|json_encode}, function(field, message){

        if(field=='captcha_code'){

          var fieldId = 'captcha_code_reset_password';
        }
        else{

          var fieldId = 'reset_'+field;
        }

        jQuery('#'+fieldId+'-error').remove();
        jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
        jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
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
        <div class="form-group">
          <label for="reset_username" class="col-md-4 control-label">Your username or email</label>
          <div class="col-md-6">
            <input type="text" id="reset_username" name="username" value="{$smarty.post.username|default:''|escape}" class="form-control" autocomplete="off">
          </div>
        </div>
        {CaptchaController::fetch('reset_password')}

        <div class="form-group">
          <label class="col-md-4 control-label">&nbsp;</label>
          <div class="col-md-6">
            <input type="submit" name="reset_password" value="Submit" class="btn btn-primary btn-lg" />
          </div>
        </div>
      </fieldset>
    </form>
    {/if}
  </div>

  {widgets area="sidebar_right"}

</div>
