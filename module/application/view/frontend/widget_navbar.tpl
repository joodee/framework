<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">{$__config.environment.global.project_name}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav navbar-right">
        {if empty($smarty.session.account.id)}
        <li{if $__route.uri=='/registration/'} class="active"{/if}><a href="/registration/">Sign Up</a></li>
        {/if}
        {if !empty($smarty.session.account.id)}
          <li{if $__route.uri=='/account/'} class="active"{/if}><a href="/account/">My Account</a></li>
        {/if}
        {if Helper::checkAccess('manager_level')}
          <li{if $__route.uri=='/admin/'} class="active"{/if}><a href="/admin/">Dashboard</a></li>
        {/if}
        <li><a href="/example/">Example Layout</a></li>


        {if !empty($smarty.session.account.id)}
        <li class="dropdown">
        <a class="dropdown-toggle authnavlink" data-toggle="dropdown" href="#">
          <span class="glyphicon glyphicon-user"></span>
          {if empty($account.nickname)}{if empty($account.first_name)}{$account.email|escape}{else}{$account.first_name|escape} {$account.last_name|escape}{/if}{else}{$account.nickname}{/if}
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li class="nav-account-profile"><a href="/profile/">Edit Profile</a></li>
          <li class="nav-account-password"><a href="/password/">Change Password</a></li>
          <li class="divider"></li>
          <li class="nav-account-logout"><a href="/logout/">Sign Out</a></li>
        </ul>
        </li>
        {else}
        <li><a class="login-modal-button authnavlink" href="/login/"><span class="glyphicon glyphicon-lock"></span> Sign In</a></li>
        {/if}




      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
