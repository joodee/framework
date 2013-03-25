<ul class="nav">
  <li{if $__route.uri=='/'} class="active"{/if}><a href="/">Home</a></li>
  {if empty($smarty.session.account.id)}
  <li{if $__route.uri=='/registration/'} class="active"{/if}><a href="/registration/">Sign Up</a></li>
  {/if}
  {if Helper::checkAccess('manager_level')}
    <li{if $__route.uri=='/admin/'} class="active"{/if}><a href="/admin/">Dashboard</a></li>
  {/if}
  {if !empty($smarty.session.account.id)}
    <li{if $__route.uri=='/account/'} class="active"{/if}><a href="/account/">Private</a></li>
  {/if}
</ul>
