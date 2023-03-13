<?php

use Privacy\Infra\View;

if (!defined("CMSIMPLE_XH_VERSION")) {header("HTTP/1.1 403 Forbidden"); exit;}

/**
 * @var View $this
 * @var string|null $message
 */
?>
<!-- privacy form -->
<form id="privacy" name="privacy" method="post">
<?if (isset($message)):?>
  <div><?=$message?></div>
<?else:?>
  <p><?=$this->text('message')?></p>
<?endif?>
  <p class="privacy_buttons">
    <button type="submit" class="submit" name="privacy_agree" value="no"><?=$this->text('label_decline')?></button>
    <button type="submit" class="submit" name="privacy_agree" value="yes"><?=$this->text('label_allow')?></button>
  </p>
</form>
<script>
if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled) {
    document.forms.privacy.style.display = "none";
}
</script>
