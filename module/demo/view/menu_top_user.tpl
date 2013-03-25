{if !empty($account)}
<ul class="nav pull-right hidden-tablet hidden-phone">
<li>
<a class="dropdown-toggle authnavlink" data-toggle="dropdown" href="#">
  <span class="icon-user icon-white"></span>
  {if empty($account.nickname)}{if empty($account.first_name)}{$account.email|escape}{else}{$account.first_name|escape} {$account.last_name|escape}{/if}{else}{$account.nickname}{/if}
  <span class="caret"></span>
</a>
<ul class="dropdown-menu">
  <li class="nav-account-profile"><a href="/profile/">Profile</a></li>
  <li class="nav-account-password"><a href="/password/">Change Password</a></li>
  <li class="divider"></li>
  <li class="nav-account-logout"><a href="/logout/">Sign Out</a></li>
</ul>
</li>
</ul>
{/if}
