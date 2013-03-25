<div class="control-group control-captcha">
  <label for="captcha_code_{$captchaNamespace}" class="control-label">Prove you're not a robot</label>
  <div class="controls">
    <img id="captcha_{$captchaNamespace}" alt="Captcha Image" class="captcha-image captcha-image-{$captchaNamespace}" src="/registration/captcha/?namespace={$captchaNamespace}&hash={$captchaNamespaceHash}&nocache={rand(1, 999999)}">
    <input type="hidden" name="namespace" value="{$captchaNamespace}" />
    <input type="hidden" name="hash" value="{$captchaNamespaceHash}" />
    <span class="help-block">Type characters in the picture above</span>
    <div class="input-prepend input-append">
      <span class="add-on btn pull-left"onclick="document.getElementById('captcha_{$captchaNamespace}').src = '/registration/captcha/?namespace={$captchaNamespace}&hash={$captchaNamespaceHash}&nocache=' + Math.random(); this.blur();" title="Reload Image"><i class="icon-refresh"></i></span>
      <span class="add-on btn pull-left">
        <object tabindex="-1" width="18" height="18" data="/module/captcha/securimage_play.swf?icon_file=/module/captcha/images/audio_icon.png&amp;audio_file=/captcha/play/{$captchaNamespace}/{$captchaNamespaceHash}/" type="application/x-shockwave-flash">
          <param name="wmode" value="transparent" />
          <param value="/module/captcha/securimage_play.swf?icon_file=/module/captcha/images/audio_icon.png&amp;audio_file=/captcha/play/{$captchaNamespace}/{$captchaNamespaceHash}/" name="movie">
        </object>
      </span>
      <input id="captcha_code_{$captchaNamespace}" type="text" maxlength="10" name="captcha_code" autocomplete="off" class="pull-left validate[required]" />
      <label class="add-on pull-left" rel="popover" data-title="Instructions" data-content="{CaptchaIntl::$quick_help|escape}"><b class="icon-question-sign"></b></label>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
