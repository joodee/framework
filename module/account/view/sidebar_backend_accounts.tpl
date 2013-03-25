<div class="span3">
  <div class="well account-sidebar-filter">
    <div class="page-header">
      <h4>Account filter</h4>
    </div>
    <form action="" method="get">
      {if !empty($smarty.get.order_by)}
      <input type="hidden" name="order_by" value="{$smarty.get.order_by|escape}" />
      {/if}
      {if !empty($smarty.get.dir)}
      <input type="hidden" name="dir" value="{$smarty.get.dir|escape}" />
      {/if}
      <fieldset>
        <div class="control-group span12">
          <label class="control-label support-placeholder" for="filter_keywords">Keywords</label>
          <div class="controls">
            <input id="filter_keywords" type="text" name="keywords" value="{$smarty.get.keywords|default:''|escape}" class="input-block-level" placeholder="Keywords" title="Keywords">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label support-placeholder" for="filter_from">Created from date</label>
          <div class="controls">
            <input id="filter_from" type="text" name="from" value="{$smarty.get.from|default:''|escape}" class="input-block-level datepicker" placeholder="Created from date" title="Created from date">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label support-placeholder" for="filter_to">Created to date</label>
          <div class="controls">
            <input id="filter_to" type="text" name="to" value="{$smarty.get.to|default:''|escape}" class="input-block-level datepicker" placeholder="Created to date" title="Created to date">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label support-placeholder" for="filter_keywords">Account role</label>
          <div class="controls">
            <select id="filter_role" name="role" class="input-block-level">
              <option value="">-- Select Role --</option>
              {foreach key=key item=item from=$__config.roles}
              <option value="{$key}"{if $key==$smarty.get.role|default:''} selected="selected"{/if}>{$item.name|escape}</option>
              {/foreach}
            </select>
          </div>
        </div>
        <div class="control-group">
          <div class="form-actions">
            <input type="submit" name="action" class="btn btn-primary" value="Filter" />
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>