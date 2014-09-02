<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Retrieve username tool</h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="/login/">Authentication</a></li>
      <li><a href="/forgot/">Recovery</a></li>
      <li class="active">Retrieve username</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row account-retrieve-username">
  <div class="col-md-8">
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


      jQuery('#account_retrieve_form :input').on('change', function(){
        jQuery(this).valid();
      });

      {if !empty($retrieve_errors)}

      {*jQuery('#account_retrieve_form :input').valid();*}

      jQuery.each({$retrieve_errors|json_encode}, function(field, message){

        if(field=='captcha_code'){
          var fieldId = 'captcha_code_retrieve_username';
        }
        else{
          var fieldId = 'retrieve_'+field;
        }

        jQuery('#'+fieldId+'-error').remove();
        jQuery('#'+fieldId).closest('.form-group').addClass('has-error');
        jQuery('#'+fieldId).closest('.form-group').find('div:first').append(jQuery('<span>').attr('id', fieldId+'-error').addClass('error-block help-block').html(message));
      });
      {/if}
    });
    </script>
    <form id="account_retrieve_form" action="{$__route.uri}" method="post" class="form-horizontal">
      <div class="alert alert-info">
        <div class="alert-error-decoration"></div>
        If you forgot your username then enter email address specified in your account profile.
        <br />You will receive your username by email.
      </div>

      <fieldset>
        <div class="form-group">
          <label for="retrieve_email" class="col-md-4 control-label">Your profile email</label>
          <div class="col-md-6">
            <input type="text" id="retrieve_email" name="email" value="{$smarty.post.email|default:''|escape}" class="form-control" autocomplete="off">
          </div>
        </div>
        {CaptchaController::fetch('retrieve_username')}

        <div class="form-group">
          <label class="col-md-4 control-label">&nbsp;</label>
          <div class="col-md-6">
            <input type="submit" name="retrieve_username" value="Submit" class="btn btn-primary btn-lg" />
          </div>
        </div>
      </fieldset>
    </form>
  </div>

  {widgets area="sidebar_right"}

</div>
