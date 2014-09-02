<div class="auth-box login-form-modal modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <a href="/registration/" class="create-account pull-right">Create an account</a>
  <h3>Sign In</h3>
</div>
<form action="http{if $__config.environment.module.account.secure_authentication}s{/if}://{$smarty.server.HTTP_HOST}/login/" method="post" class="login-form">
<div class="modal-body">
  <div class="col-md-11">
  <div class="form-group control-username">
    <label for="login_form_username_modal" class="control-label">Username</label>
    <div class="controls">
      <input id="login_form_username_modal" type="text" name="username" class="form-control input-username" />
    </div>
  </div>
  <div class="form-group control-password">
    <label for="login_form_password_modal" class="control-label">Password</label>
    <div class="controls">
      <input id="login_form_password_modal" type="password" name="password" class="form-control input-password" />
    </div>
  </div>
  <div class="form-group control-remember">
    <div class="controls">
      <label for="login_form_remember_modal" class="checkbox-remember display-inline" rel="popover" data-title="{AccountIntl::$auth_remember_title|escape}" data-content="{AccountIntl::$auth_remember_note|escape}">
        <input id="login_form_remember_modal" type="checkbox" name="remember" value="1" />
        Keep me signed in
      </label>
    </div>
  </div>
  {if $authFailCount}
    {CaptchaController::fetch('authentication_modal', 'account', 'captcha_authentication.tpl')}
  {/if}
  </div>
  <div class="clearfix"></div>
</div>
<div class="modal-footer">
  <a href="/forgot/" class="forgot-password pull-left">Can't access your account?</a>
  <input type="submit" name="sign_in" value="Sign In" class="btn btn-primary" />
  <a href="#" class="btn btn-default btn-close">Close</a>
</div>
</form>
      </div>
  </div>
</div>
