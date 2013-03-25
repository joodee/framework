<div class="span9">
  {Alert::fetchAll()}
  <div class="controller well account-manager content-height-min">
    <div class="page-header clearfix">
      <h2 class="pull-left">Accounts</h2>
      <h2 class="pull-right"><a href="/registration/" class="btn pull-right" target="_blank"><i class="icon-user"></i> New Account</a></h2>
    </div>
    <div>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
          <tr>
            <th>{Order::link('acc_id', 'Id')}</th>
            <th>{Order::link('nickname', 'Nickname')}</th>
            <th>{Order::link('full_name', 'Full name')}</th>
            <th>{Order::link('username', 'User name')}</th>
            <th class="hidden-phone">{Order::link('email', 'Email')}</th>
            <th class="hidden-tablet hidden-phone">{Order::link('role', 'Role')}</th>
            <th class="hidden-tablet hidden-phone">{Order::link('created_at', 'Created')}</th>
            <th class="actions-column">Actions</th>
          </tr>
        </thead>
        <tbody>
        {foreach item=item from=$accountList}
          <tr id="account_{$item.acc_id}">
            <td class="account-id-column">{$item.acc_id}</td>
            <td>{$item.nickname|escape}</td>
            <td>{$item.first_name|escape} {$item.last_name|escape}</td>
            <td>{$item.username|escape}</td>
            <td class="hidden-phone"><a href="#email-message" title="Send Message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/', {$item.acc_id});">{$item.email|escape}</a></td>
            <td class="hidden-tablet hidden-phone"><a href="#role" id="role_{$item.acc_id}" title="Change Role" onclick="return jQuery.joodeeAccountManager.changeRole({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_change_role|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?', jQuery(this).attr('rel'));" rel="{$item.role}">{$__config.roles[$item.role].name|escape}</a></td>
            <td class="hidden-tablet hidden-phone">{$item.created_at}</td>
            <td class="actions-column">
              <button class="btn btn-info" title="Account Info" onclick="jQuery.joodeeAccountManager.accountInfo({$item.acc_id}, '{$__route.uri}');"><i class="icon-info-sign icon-white"></i></button>
              <button class="btn btn-success offset1" title="Sign In As" onclick="jQuery.joodeeAccountManager.signInAs({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_sign_in_as|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?');"><i class="icon-play icon-white"></i></button>
              <button class="btn{if $item.locked=='No'} btn-warning{/if} offset1" title="Lock / Unlock" id="lock_{$item.acc_id}" onclick="jQuery.joodeeAccountManager.lockAccount({$item.acc_id}, '{$__route.uri}', '{if $item.locked=='Yes'}{AccountIntl::$manager_confirm_unlock|escape}{else}{AccountIntl::$manager_confirm_lock|escape}{/if}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?', this);"><i class="{if $item.locked=='No'}icon-ban-circle icon-white{else}icon-lock icon-black{/if}"></i></button>
              <button class="btn btn-danger offset1 hidden-tablet hidden-phone" title="Delete" onclick="jQuery.joodeeAccountManager.deleteAccount({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_deletion|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?');"><i class="icon-trash icon-white"></i></button>
            </td>
          </tr>
        {foreachelse}
          <tr>
            <td colspan="8">List is empty</td>
          </tr>
        {/foreach}
        </tbody>
      </table>
      {Pager::fetch($accountList|count, $foundRows, $rowsPerPage)}

<script type="text/javascript">
  var roleList = {$__config.roles|json_encode};
</script>

    </div>
  </div>
</div>