<div class="row">
  <div class="col-md-12">
    <h1 class="page-header">{$__view.title}</h1>
    {Alert::fetchAll()}
  </div>
</div>
<div class="row page-setup">
  <div class="col-md-12">
    <section>

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

        <p style="margin-top: 40px;">
          <input type="button" name="reload" value="Check Again" class="btn-lg btn-primary" onclick="document.location.reload();" />
        </p>

      </section>
  </div>
</div>
