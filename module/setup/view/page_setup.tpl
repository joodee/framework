<div class="controller page-setup well">
  <section>
    <div class="page-header">
      <h2>Setting up</h2>
    </div>

    <table class="table table-bordered table-striped">
      <tr>
        <th width="40%">Check</th>
        <th>Status</th>
      </tr>
      {foreach item=item from=$settings}
        <tr>
          <td>{$item.label}</td>
          <td><b class="{if $item.status=='Ok'}text-success{else}text-error{/if}">{$item.status}</b></td>
        </tr>
      {/foreach}
    </table>

    <p style="margin-top: 40px;"><input type="button" name="reload" value="Check Again" class="btn-large btn-primary" /></p>

  </section>
</div>
