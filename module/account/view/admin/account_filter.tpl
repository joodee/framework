<div class="well account-filter">
  <div class="col-md-10">
    <div class="row">
  <form action="" method="get" class="form-inline" role="form">
    {if !empty($smarty.get.order_by)}
    <input type="hidden" name="order_by" value="{$smarty.get.order_by|escape}" />
    {/if}
    {if !empty($smarty.get.dir)}
    <input type="hidden" name="dir" value="{$smarty.get.dir|escape}" />
    {/if}
    <fieldset>
      <div class="form-group">
        <label class="control-label support-placeholder" for="filter_keywords">Keywords</label>
        <div>
          <input id="filter_keywords" type="text" name="keywords" value="{$smarty.get.keywords|default:''|escape}" class="form-control" placeholder="Keywords" title="Keywords">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label support-placeholder" for="filter_from">Created from date</label>
        <div>
          <input id="filter_from" type="text" name="from" value="{$smarty.get.from|default:''|escape}" class="form-control datepicker" placeholder="Created from date" title="Created from date">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label support-placeholder" for="filter_to">Created to date</label>
        <div>
          <input id="filter_to" type="text" name="to" value="{$smarty.get.to|default:''|escape}" class="form-control datepicker" placeholder="Created to date" title="Created to date">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label support-placeholder" for="filter_keywords">Account role</label>
        <div>
          <select id="filter_role" name="role" class="form-control">
            <option value="">-- Role --</option>
            {foreach key=key item=item from=$__config.roles}
            <option value="{$key}"{if $key==$smarty.get.role|default:''} selected="selected"{/if}>{$item.name|escape}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group" style="width: 60px; margin-right: 0;">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </fieldset>
  </form>
    </div>
  </div>
  <div class="col-md-2 pull-right">
    <a href="/registration/" class="btn btn-default pull-right clearfix" target="_blank"><i class="glyphicon glyphicon-user"></i> New Account</a>
  </div>
</div>
