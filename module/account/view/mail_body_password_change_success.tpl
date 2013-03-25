<html xmlns="http://www.w3.org/1999/html">
<body>
<div style="background-color:#1E505D;color:#ffffff;padding: 2px 20px;">
  <h1>{$__config.environment.global.company_name|strtoupper} - PASSWORD SUCCESSFULLY CHANGED</h1>
</div>
<div style="padding: 4px 20px; width: 700px;">
<p style="font-weight: bolder;">Dear {$account.first_name|escape},</p>
<p>
  your password has been successfully changed.
</p>
<p style="font-weight: bolder;padding-top: 20px;">P.S.</p>
<p>
  This email was sent automatically, please do not respond.
</p>
</div>
<div style="background-color:#cbcfd6;padding: 10px 20px;">
  Sincerely,<br />
  <span style="font-weight: bolder;">{$__config.environment.global.company_name}</span><br />
  <a href="http://{$smarty.server.HTTP_HOST}/">{$smarty.server.HTTP_HOST}</a>
</div>
</body>
</html>
