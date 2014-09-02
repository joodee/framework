{if $toAccount.first_name|default:''}
Dear {$toAccount.first_name|escape|default:''},

{else}



{/if}
--
Kind Regards,
{$fromAccount.first_name|escape} {$fromAccount.last_name|escape}
{$fromAccount.mobile_phone|escape}
{$fromAccount.email|escape}
