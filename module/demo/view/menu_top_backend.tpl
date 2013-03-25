<ul class="nav">
  <li{if $__route.uri=='/admin/'} class="active"{/if}><a href="/admin/">Dashboard</a></li>
  {if Helper::checkAccess('admin_level')}
  <li{if $__route.uri=='/admin/sendmail/'} class="active"{/if}><a href="/admin/accounts/">Accounts</a></li>
  {/if}
  <li><a href="#email-message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/');">Send Email</a></li>
</ul>
