<div class="row">
  <div class="col-md-12">
    <h1>Account Manager</h1>
    <ol class="breadcrumb">
      <li><a href="/admin/"><i class="icon-dashboard"></i> Dashboard</a></li>
      <li class="active"><i class="icon-user"></i> Accounts</li>
    </ol>
    {Alert::fetchAll()}
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-md-12">
        {widgets area="account_filter"}
      </div>
    </div>
    <div class="account-manager">

      <div class="clearfix">
        <table class="table table-striped table-bordered table-condensed table-hover">
          <thead>
            <tr>
              <th>{Order::link('acc_id', 'Id')}</th>
              <th>{Order::link('nickname', 'Nickname')}</th>
              <th>{Order::link('full_name', 'Full name')}</th>
              <th>{Order::link('username', 'User name')}</th>
              <th class="hidden-sm">{Order::link('email', 'Email')}</th>
              <th class="hidden-md hidden-sm">{Order::link('role', 'Role')}</th>
              <th class="hidden-md hidden-sm">{Order::link('created_at', 'Created')}</th>
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
              <td class="hidden-sm"><a href="#email-message" title="Send Message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/', {$item.acc_id});">{$item.email|escape}</a></td>
              <td class="hidden-md hidden-sm"><a href="#role" id="role_{$item.acc_id}" title="Change Role" onclick="return jQuery.joodeeAccountManager.changeRole({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_change_role|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?', jQuery(this).attr('rel'));" rel="{$item.role}">{$__config.roles[$item.role].name|escape}</a></td>
              <td class="hidden-md hidden-sm">{$item.created_at}</td>
              <td class="actions-column">
                <div class="row">
                  <div class="col-md-3"><button class="btn btn-info" title="Account Info" onclick="jQuery.joodeeAccountManager.accountInfo({$item.acc_id}, '{$__route.uri}');"><i class="glyphicon glyphicon-info-sign"></i></button></div>
                  <div class="col-md-3"><button class="btn btn-success" title="Sign In As" onclick="jQuery.joodeeAccountManager.signInAs({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_sign_in_as|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?');"><i class="glyphicon glyphicon-play"></i></button></div>
                  <div class="col-md-3"><button class="btn{if $item.locked=='No'} btn-warning{else} btn-default{/if}" title="Lock / Unlock" id="lock_{$item.acc_id}" onclick="jQuery.joodeeAccountManager.lockAccount({$item.acc_id}, '{$__route.uri}', '{if $item.locked=='Yes'}{AccountIntl::$manager_confirm_unlock|escape}{else}{AccountIntl::$manager_confirm_lock|escape}{/if}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?', this);"><i class="{if $item.locked=='No'}glyphicon glyphicon-ban-circle{else}glyphicon glyphicon-lock{/if}"></i></button></div>
                  <div class="col-md-3"><button class="btn btn-danger hidden-xs hidden-sm" title="Delete" onclick="jQuery.joodeeAccountManager.deleteAccount({$item.acc_id}, '{$__route.uri}', '{AccountIntl::$manager_confirm_deletion|escape}{$item.acc_id} {$item.nickname|escape} [{$item.username|escape}]?');"><i class="glyphicon glyphicon-trash"></i></button></div>
                </div>
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
</div>