<div class="controller page-login well">

  <div class="auth-box well modal" style="position: relative; top: auto; left: auto; margin: 100px auto; z-index: 1;">
  <div class="modal-header">
    <h3 class="pull-left">Authentication required</h3>
    <a href="/registration/" class="create-account pull-right">Create an account</a>
    <div class="clearfix"></div>
  </div>
  <form action="http{if $__config.environment.module.account.secure_authentication}s{/if}://{$smarty.server.HTTP_HOST}/login/" method="post" class="form-vertical login-form">
    <input type="hidden" name="redirect" value="{if $__route.uri != $smarty.server['REQUEST_URI']}{$smarty.server['REQUEST_URI']}{/if}" />
    <div class="modal-body">

      <div id="login_form">
        <div class="control-group control-username clearfix">
          <label for="login_form_username">Username</label>
          <input id="login_form_username" type="text" name="username" class="input-username" />
        </div>
        <div class="control-group control-password clearfix">
          <label for="login_form_password">Password</label>
          <input id="login_form_password" type="password" name="password" class="input-password" />
        </div>
        <div class="control-group control-remember clearfix">
          <label for="login_form_remember" class="checkbox checkbox-remember display-inline" rel="popover" data-title="{AccountIntl::$auth_remember_title|escape}" data-content="{AccountIntl::$auth_remember_note|escape}">
            <input id="login_form_remember" type="checkbox" name="remember" value="1" />
            Keep me signed in
          </label>
        </div>
      {if $authFailCount}
        {CaptchaController::fetch('authentication')}
      {/if}
      </div>
    </div>
    <div class="modal-footer">
      <a href="/forgot/" class="forgot-password pull-left">Can't access your account?</a>
      <input type="submit" name="sign_in" value="Sign In" class="btn btn-primary pull-left" />
    </div>
  </form>
  </div>

</div>