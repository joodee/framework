<table class="table table-striped table-bordered table-condensed table-hover table-account-info">
  <tbody>
    <tr>
      <th>Id</th>
      <td>{$account.acc_id}</td>
    </tr>
    <tr>
      <th>Nickname</th>
      <td>{$account.nickname|escape|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>First name</th>
      <td>{$account.first_name|escape|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Last name</th>
      <td>{$account.last_name|escape|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Username</th>
      <td>{$account.username|escape}</td>
    </tr>
    <tr>
      <th>Activated</th>
      <td>{$account.activated}</td>
    </tr>
    <tr>
      <th>Email</th>
      <td><a href="#email-message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/', {$account.acc_id});">{$account.email|escape|default:'&nbsp;'}</a></td>
    </tr>
    <tr>
      <th>Canonical email</th>
      <td><a href="#email-message" onclick="return jQuery.joodeeAccountManager.emailMessage('/admin/sendmail/', {$account.acc_id}, '{$account.first_name|escape} {$account.last_name|escape} &lt;{$account.email_canonical|escape}&gt;');">{$account.email_canonical|escape|default:'&nbsp;'}</a></td>
    </tr>
    <tr>
      <th>Mobile phone</th>
      <td>{$account.mobile_phone|escape|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Role</th>
      <td>{$__config.roles[$account.role].name|escape}</td>
    </tr>
    <tr>
      <th>Gender</th>
      <td>{$account.gender|escape}</td>
    </tr>
    <tr>
      <th>Birthday</th>
      <td>{$account.birthday}</td>
    </tr>
    <tr>
      <th>Location</th>
      <td>{CountryList::$items[$account.location_iso2].name|default:$account.location_iso2|escape}</td>
    </tr>
    <tr>
      <th>Timezone</th>
      <td>{$account.timezone|escape}</td>
    </tr>
    <tr>
      <th>Created</th>
      <td>{$account.created_at|escape}</td>
    </tr>
    <tr>
      <th>Updated</th>
      <td>{$account.updated_at|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Last signed in</th>
      <td>{$account.last_logged_at|default:'&nbsp;'}</td>
    </tr>
{if !Helper::isDemoRole()}
    <tr>
      <th>Last logged IP</th>
      <td>{$account.last_logged_ip|default:'&nbsp;'}</td>
    </tr>
{/if}
    <tr>
      <th>Password requested</th>
      <td>{$account.password_requested_at|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Deletion requested</th>
      <td>{$account.deletion_requested_at|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Deletion scheduled</th>
      <td>{$account.deletion_scheduled_at|default:'&nbsp;'}</td>
    </tr>
    <tr>
      <th>Locked</th>
      <td>{$account.locked}</td>
    </tr>
    <tr>
      <th>Lock reason</th>
      <td>{$account.lock_reason|escape|default:'&nbsp;'}</td>
    </tr>
  </tbody>
</table>
