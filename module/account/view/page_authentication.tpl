<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">Sign In <small>Private Area</small></h1>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li class="active">Authentication</li>
    </ol>
    {Alert::fetchAll()}
  </div>
</div>

<div class="row page-auth">
  <div class="col-md-8 col-md-offset-2">
    <div class="auth-box well clearfix" style="position: relative; top: auto; left: auto; margin: 20px auto; z-index: 1;">
    <div class="modal-header">
      <h3 class="pull-left">Authentication</h3>
      <a href="/registration/" class="create-account pull-right">Create an account</a>
      <div class="clearfix"></div>
    </div>
    <form action="http{if $__config.environment.module.account.secure_authentication}s{/if}://{$smarty.server.HTTP_HOST}/login/" method="post" class="form-vertical login-form">
      <input type="hidden" name="redirect" value="{if $__route.uri != $smarty.server['REQUEST_URI']}{$smarty.server['REQUEST_URI']}{/if}" />
      <div class="modal-body">
        <div id="login_form" class="col-md-11">
          <div class="form-group control-username">
            <label for="login_form_username" class="control-label">Username</label>
            <div class="controls">
              <input id="login_form_username" type="text" name="username" class="form-control input-username" />
            </div>
          </div>
          <div class="form-group control-password">
            <label for="login_form_password" class="control-label">Password</label>
            <div class="controls">
              <input id="login_form_password" type="password" name="password" class="form-control input-password" />
            </div>
          </div>
          <div class="form-group control-remember">
            <div class="controls">
              <label for="login_form_remember" class="checkbox-remember display-inline" rel="popover" data-title="{AccountIntl::$auth_remember_title|escape}" data-content="{AccountIntl::$auth_remember_note|escape}">
                <input id="login_form_remember" type="checkbox" name="remember" value="1" />
                Keep me signed in
              </label>
            </div>
          </div>
        {if $authFailCount}
          {CaptchaController::fetch('authentication', 'account', 'captcha_authentication.tpl')}
        {/if}
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <a href="/forgot/" class="forgot-password pull-left">Can't access your account?</a>
        <input type="submit" name="sign_in" value="Sign In" class="btn btn-primary pull-left" />
      </div>
    </form>
    </div>
  </div>

  {widgets area="sidebar_right"}

</div>
