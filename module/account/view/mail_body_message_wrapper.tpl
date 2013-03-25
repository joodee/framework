<html xmlns="http://www.w3.org/1999/html">
<body>
<div style="background-color:#1E505D;color:#ffffff;padding: 2px 20px;">
  <h1>{$__config.environment.global.company_name|strtoupper}</h1>
</div>
<div style="padding: 4px 20px; width: 700px;">
<p>
{$message}
</p>
</div>
<div style="background-color:#cbcfd6;padding: 10px 20px;">
  <span style="font-weight: bolder;">{$__config.environment.global.company_name}</span><br />
  <a href="http://{$smarty.server.HTTP_HOST}/">{$smarty.server.HTTP_HOST}</a>
</div>
</body>
</html>
