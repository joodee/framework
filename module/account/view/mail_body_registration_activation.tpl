<html xmlns="http://www.w3.org/1999/html">
<body>
<div style="background-color:#1E505D;color:#ffffff;padding: 2px 20px;">
  <h1>{$__config.environment.global.company_name|strtoupper} - REGISTRATION</h1>
</div>
<div style="padding: 4px 20px; width: 700px;">
<p style="font-weight: bolder;">Dear {$account.first_name|escape}</p>
<p>
  Thank you for your registration at <a href="http://{$smarty.server.HTTP_HOST}">{$__config.environment.global.company_name}</a>!
</p>
<p>
  <span style="font-weight: bolder;">Your activation code is:</span> {$activation_code}
</p>
<p>
  If you closed activation form, click the following link:<br />
  <a href="{$activation_url}">{$activation_url}</a>
</p>
{if $__config.environment.module.account.schedule_deletion_if_not_activated_x_days}
<p>
  <span style="font-weight: bolder;">Please note</span>, activation code will expire within {$__config.environment.module.account.schedule_deletion_if_not_activated_x_days*24} hours, so please do not hesitate to activate your account.
</p>
{/if}
<p style="font-weight: bolder;padding-top: 20px;">P.S.</p>
<p>
  This email was sent automatically, please do not respond.
</p>
<p>
  You received this letter because you, or someone else, requested a new user account at
  <a href="http{if $__config.environment.module.account.secure_authentication}s{/if}://{$smarty.server.HTTP_HOST}">{$smarty.server.HTTP_HOST}</a>
</p>
<p>
  If you didn't register with <a href="http://{$smarty.server.HTTP_HOST}">{$smarty.server.HTTP_HOST}</a> then
  someone else may type in your email address by accident. If that is what happened, then ignore this
  letter{if $__config.environment.module.account.schedule_deletion_if_not_activated_x_days} and your email address will be scheduled for deletion from our database automatically within {$__config.environment.module.account.delete_if_not_activated_for_x_days*24} hours{/if}.
</p>
</div>
<div style="background-color:#cbcfd6;padding: 10px 20px;">
  Sincerely,<br />
  <span style="font-weight: bolder;">{$__config.environment.global.company_name}</span><br />
  <a href="http://{$smarty.server.HTTP_HOST}/">{$smarty.server.HTTP_HOST}</a>
</div>
</body>
</html>
