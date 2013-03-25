<div class="auth-box login-form-modal modal hide">
<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <a href="/registration/" class="create-account pull-right">Create an account</a>
  <h3>Sign In</h3>
</div>
<form action="http{if $__config.environment.module.account.secure_authentication}s{/if}://{$smarty.server.HTTP_HOST}/login/" method="post" class="login-form">
<div class="modal-body">
    <div class="control-group control-username clearfix">
        <label for="login_form_username_modal">Username</label>
        <input id="login_form_username_modal" type="text" name="username" class="input-username" />
    </div>
    <div class="control-group control-password clearfix">
        <label for="login_form_password_modal">Password</label>
        <input id="login_form_password_modal" type="password" name="password" class="input-password" />
    </div>
    <div class="control-group control-remember clearfix">
        <label for="login_form_remember_modal" class="checkbox checkbox-remember display-inline" rel="popover" data-title="{AccountIntl::$auth_remember_title|escape}" data-content="{AccountIntl::$auth_remember_note|escape}">
            <input id="login_form_remember_modal" type="checkbox" name="remember" value="1" />
            Keep me signed in
        </label>
    </div>
    {if $authFailCount}
      {CaptchaController::fetch('authentication_modal')}
    {/if}
</div>
<div class="modal-footer">
  <a href="/forgot/" class="forgot-password pull-left">Can't access your account?</a>
  <input type="submit" name="sign_in" value="Sign In" class="btn btn-primary" />
  <a href="#" class="btn btn-close">Close</a>
</div>
</form>
</div>
