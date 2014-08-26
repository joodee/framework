<div class="alert alert-danger">
  <div class="alert-error-decoration"></div>
  <a data-dismiss="alert" class="close">&times;</a>
  {if $alertTitle}<h3>{$alertTitle}</h3>{/if}
  {if $alertMessage|is_array}
  <ul>
    {foreach item=item from=$alertMessage}
    <li>{$item}</li>
    {/foreach}
  </ul>
  {else}
    {$alertMessage}
  {/if}
</div>
